<table id="datatable_checkup_modal" class="table  table-striped text-11">
    <thead>
    <tr>
        <th>#</th>
        <th>Reference Name</th>
        <th>Reference Phone No</th>
        {{-- <th>Action</th> --}}
    </tr>
    </thead>
    <tbody>


    @foreach ($gamer_array as $obj)
    <tr>

       <td> {{$obj['sn']}}</td>
        <td>
            <span> {{$obj['ref_name']}}</span>
        </td>
        <td>
            <span> {{$obj['ref_no']}}</span>
        </td>
    </tr>
@endforeach
    </tbody>
</table>
