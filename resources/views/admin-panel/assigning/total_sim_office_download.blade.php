<h1 class="align-content-center">Total Office  Sims</h1>
<table class="table" id="datatable" style="width:100%">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">ID</th>
        <th scope="col">Account Number</th>
        <th scope="col">Name</th>
        <th scope="col">Assigned As</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">PPUID</th>
        <th scope="col">Passport No</th>
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
    @foreach($office_sim as $tel)
        <tr>
            <th scope="row">1</th>
            <td>{{$tel->id}}</td>
            <td>{{$tel->telecome->account_number}}</td>
            <td>
                {{$tel->name}}
            </td>
            <td>{{$tel->assign_to->name}}</td>
            <td>
                {{isset($tel->assign_to->passport->zds_code->zds_code)?$tel->assign_to->passport->zds_code->zds_code:"N/A"}}
            </td>
            <td>
                {{isset($tel->assign_to->passport->pp_uid)?$tel->assign_to->passport->pp_uid:"N/A"}}
            </td>
            <td>
                {{isset($tel->assign_to->passport->passport_no)?$tel->assign_to->passport->passport_no:"N/A"}}
            </td>

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
