<table class="display table table-sm table-striped table-bordered" >
    <thead class="thead-dark">
    <tr>
        <th scope="col"><b>Rider Name</b></th>
        <th scope="col"><b>Zds Code</b></th>
        <th scope="col"><b>Passport No</b></th>
        <th scope="col"><b>Platform Name</b></th>
        <th scope="col"><b>DC Name</b></th>
        <th scope="col"><b>Assign DC date</b></th>

    </tr>
    </thead>
    <tbody>
    @foreach($assign_to_dc as $user)
        <tr>
            <td>{{ $user->passport->personal_info->full_name }}</td>
            <td>{{ isset($user->passport->rider_zds_code->zds_code) ? $user->passport->rider_zds_code->zds_code : 'N/A' }}</td>
            <td>{{ $user->passport->passport_no }}</td>
            <td>{{ $user->platform->name }}</td>
            <td>{{ $user->user_detail->name }}</td>
            <td>{{ $user->created_at }}</td>

        </tr>
    @endforeach
    </tbody>

</table>
