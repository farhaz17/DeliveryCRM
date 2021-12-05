<div class="table-responsive">
    <table class="display table table-striped table-bordered" id="datatable_additional_info">
        <thead class="thead-dark">
        <tr>
            <th scope="col" style="width: 100px">ID</th>
            <th scope="col" style="width: 100px">PP UID</th>
            <th scope="col" style="width: 100px">Passport #</th>
            <th scope="col" style="width: 200px">Name</th>
            <th scope="col" style="width: 100px">Nationality</th>
            <th scope="col" style="width: 100px">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($passport as $row)
            <tr>
                <td> {{$row->id}}</td>
                <td> {{$row->pp_uid}}</td>
                <td> {{$row->passport_no}}
                    @if(isset($row->renew_pass))
                        <span>/N</span>
                    @elseif(isset($row->wrong_pass))
                        <span>/C</span>
                    @else
                    @endif
                </td>
                <td> {{isset($row->personal_info)?$row->personal_info->full_name:'' }}</td>
                <td>{{$row->nation->name}}</td>
                <td>
                    <a class="text-success mr-2" href="{{route('view_passport.edit',$row->id)}}" target="_blank"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
