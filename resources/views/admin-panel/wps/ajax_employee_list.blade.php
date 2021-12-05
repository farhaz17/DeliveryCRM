<table class="display table table-striped table-bordered" id="datatable_passport">
    <thead class="thead-dark">
    <tr>
        <th scope="col" style="width: 100px">Company Name</th>
        <th scope="col" style="width: 100px">Full Name</th>
        <th scope="col" style="width: 100px">Passport No</th>
        <th scope="col" style="width: 100px">PPUID</th>
        <th scope="col" style="width: 100px">ZDS Code</th>
        <th scope="col" style="width: 100px">Labour card No</th>
        <th scope="col" style="width: 100px">Action</th>
    </tr>
    </thead>
    <tbody class="wait-loader-paginate" style="display: none"><tr><img class="wait-loader-paginate" style="display: none" src="{{asset('assets/images/load-gif.gif')}}" width="300" /></tr></tbody>
    <tbody>
        @foreach($employees as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->full_name}}</td>
            <td>{{$row->passport_no}}</td>
            <td>{{$row->pp_uid}}</td>
            <td>{{$row->zds_code}}</td>
            <td>{{$row->labour_card_no}}</td>
            <td><button class="btn btn-success add-wps" type="submit" value="{{$row->passport_no}}">Add WPS</button></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7" class="text-center">
                {!! $employees->links() !!}
            </td>
        </tr>
    </tbody>
</table>
