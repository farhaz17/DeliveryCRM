<div class="card text-left">
    <div class="card-body">
        <div class="table-responsive">
            <table  id="datatable_checkups" class="table table-sm table-hover table-striped text-11 data_table_cls" >
                <thead>
                <tr>
                    <th scope="col"><b>Repair No</b></th>
                    <th scope="col"> <b>Plate No </b></th>
                    <th scope="col"> <b>Chassis No </b></th>
                    <th scope="col"> <b>Name </b></th>
                    <th scope="col"> <b>Remarks </b></th>
                    <th scope="col"> <b>Checkup Points </b></th>
                    <th scope="col"> <b>Date & Hours </b></th>
                </tr>
                </thead>
                <tbody>

                @foreach($checkup_detail as $row)
                    <tr>
                        <td>{{$row->manage_repair->repair_no}}</td>
                        <td>{{$row->manage_repair->bike->plate_no}}</td>
                        <td>{{$row->manage_repair->bike->chassis_no}}</td>
                        <td> {{$row->manage_repair->passport->personal_info->full_name}}</td>
                        <td> {{isset($row->remarks)?$row->remarks:'N/A'}}</td>

                        <td><button class="btn text-success"  onclick="get_checkup_points({{$row->id}})" type="button"><i class="fa fa-list"></i></button></td>
                        <td> {{$row->days_hours}}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
