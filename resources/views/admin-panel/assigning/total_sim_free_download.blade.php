<h1>Total Free  Sims</h1>
<table class="table" id="datatable" style="width:100%">
    <thead class="thead-dark">
    <tr>

        <th scope="col">Account Number</th>
        <th scope="col">Party ID</th>
        <th scope="col">Product Type</th>
        <th scope="col">Network</th>
        <th scope="col">Category Tpes</th>
        @if(in_array(1, Auth::user()->user_group_id))
            <th scope="col">Action</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($free_sim as $tel)
        <tr>
            <td>{{$tel->account_number}}</td>
            <td>{{$tel->party_id}}</td>
            <td>{{$tel->product_type}}</td>
            <td>{{$tel->network}}</td>
            @if($tel->category_types=='0')
                <td>Company</td>
            @else
                <td>Platform</td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>
