<table class="display table table-striped table-bordered table-sm text-10" id="datatable-7" width="100%">

    <thead>
    <tr>


        <th scope="col">Name</th>
        <th scope="col">Passport No</th>
        <th scope="col">PPUID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
    {{-- @if($row['visa_status']=='1') --}}
        <tr>


            <td>
                {{$row['name']}}

            </td>
            <td> {{$row['pass_no']}}</td>
            <td> {{$row['pp_uid']}}</td>


        </tr>
        {{-- @endif --}}
    @endforeach



    </tbody>
</table>


