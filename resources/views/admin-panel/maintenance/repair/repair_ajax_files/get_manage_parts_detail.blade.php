<div class="card text-left">
    <div class="card-body">
        <div class="table-responsive">
            <table  id="datatable_manage_repair" class="table table-sm table-hover table-striped text-11 data_table_cls" >
                <thead>
                <tr>
                    <th scope="col"> <b> Repair No </b></th>
                    <th scope="col"> <b>Plate No </b></th>
                    <th scope="col"> <b>Chassis No </b></th>
                    <th scope="col"> <b>Name </b></th>
                    <th scope="col"> <b>Parts Detail </b></th>
                    {{-- <th scope="col">Company or Own</th> --}}
                    <th scope="col"> <b>Status </b></th>
                    <th scope="col"> <b>Inventory Status </b></th>


                </tr>
                </thead>
                <tbody>


                @foreach($manage_parts as $row)
                    <tr>
                        <td>{{$row->manage_repair->repair_no}}</td>
                        <td>{{$row->manage_repair->bike->plate_no}}</td>
                        <td>{{$row->manage_repair->bike->chassis_no}}</td>
                        <td> {{$row->manage_repair->passport->personal_info->full_name}}</td>
                      <td>
                          <button class="btn text-success"  onclick="get_manage_parts({{$row->id}})" type="button">
                            <i class="text-20 i-Gear-2"></i>
                        </button>
                    </td>
                        {{-- <td>{{($manage_repair->company_or_own == '0')?"Own":"Company"}}</td> --}}
                    <td>
                        @if($row->status=='0')
                        <span class="badge badge-danger m-2">Pending</span>
                        @elseif($row->status=='1')
                        <span class="badge badge-info m-2">In Progress</span>
                        @else
                        <span class="badge badge-success m-2">Completed</span>
                        @endif
                    </td>
                    <td>
                        @if($row->inv_status=='0')
                        <span class="badge badge-danger m-2">Not Verified Yet</span>
                        @else
                        <span class="badge badge-success m-2">Verified</span>
                        @endif
                    </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
