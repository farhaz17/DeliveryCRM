<h1>Total Rider  Sims</h1>
<table class="table" id="datatable" style="width:100%">
    <thead class="thead-dark">
    <tr>
{{--        <th scope="col">#</th>--}}
{{--        <th scope="col">ID</th>--}}
        <th scope="col">Account Number</th>
        <th scope="col">Name</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">Passport</th>
        <th scope="col">PPUID</th>
        <th scope="col">Platform</th>
        <th scope="col">Party ID</th>
        <th scope="col">Product Type</th>
        <th scope="col">Network</th>
        <th scope="col">Category Tpes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($rider_sim as $tel)
        <tr>
{{--            <th scope="row">1</th>--}}
{{--            <td>{{$tel->id}}</td>--}}
            <td>{{$tel->telecome->account_number}}</td>
            <td>{{$tel->passport->personal_info->full_name}}</td>
            <td>{{$tel->passport->passport_number}}</td>
            <td>{{$tel->passport->zds_code->zds_code}}</td>
            <td>{{$tel->passport->pp_uid}}</td>
{{--            <td>{{$tel->plateform->plateformdetail->name}}</td>--}}

{{--            @if (!$tel->plateform->isEmpty())--}}
            <td>{{ $tel->assign_plateform() ? $tel->assign_plateform()->plateformdetail->name :"N/A"}}</td>
{{--            @else--}}
{{--                <td>N/A</td>--}}
{{--            @endif--}}

{{--            <td>{{$tel->plateform->plateformdetail->name}}</td>--}}
            <td>{{$tel->telecome->party_id}}</td>
            <td>{{$tel->telecome->product_type}}</td>
            <td>{{$tel->telecome->network}}</td>
            @if($tel->telecome->category_types=='0')
                <td>Company</td>
            @else
                <td>Platform</td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>
