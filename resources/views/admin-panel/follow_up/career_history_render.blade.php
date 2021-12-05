

@foreach($histories as $career)

    <tr>
        <th scope="row">{{ $career->id }}</th>
        <td>{{ $career->company_remarks  }}</td>
        <td>{{ $career->remarks  }}</td>
        <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'N/A'  }}</td>
        <td>{{ $career->created_at }}</td>
    </tr>
@endforeach






