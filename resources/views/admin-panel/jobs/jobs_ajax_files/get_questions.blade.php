<table id="datatable_checkup_modal" class="table  table-striped text-11">
    <thead>
    <tr>
        <th>#</th>
        <th>Question</th>
        {{-- <th>Action</th> --}}
    </tr>
    </thead>
    <tbody>


    @foreach ($gamer_array as $obj)
    <tr>

       <td> {{$obj['sn']}}</td>
        <td  class="point_checkup">
            <span> {{$obj['question']}}</span>
        </td>
    </tr>
@endforeach
    </tbody>
</table>
