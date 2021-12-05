@if(!empty($cod_uploads))
    @foreach($cod_uploads as $cod)
        <tr>
            <th>{{$cod->id}}</th>
            <td>{{ $cod->rider_id }}</td>
            <td>{{ $cod->amount }} <span class="badge badge-success">AED</span></td>
            <td>{{ $cod->start_date }}</td>
            <td>{{ $cod->end_date }}</td>
            <td>{{ $cod->platform->name }}</td>
        </tr>
    @endforeach

@endif
