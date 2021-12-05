<table class="table table-bordered table-striped " id="takaful_table">
    <thead class="thead-dark">
    <tr class="history_table">
        <th>Name</th>
        <th>Passport No</th>
        <th>PPUID</th>
        <th>Amount</th>
        <th>Date Issue</th>
        <th>Date Expiry</th>
        <th>Added By</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($glwmc as $row )
        <tr>
            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
            <td>{{isset($row->amount)?$row->amount:"N/A"}}</td>
            <td>{{isset($row->issue_date->name)?$row->issue_date:"N/A"}}</td>
            <td>{{isset($row->expiry_date)?$row->expiry_date:"N/A"}}</td>
            <td>{{isset($row->user_info->name)?$row->user_info->name:"N/A"}}</td>
            <td>
                <a class="text-success mr-2" href="{{route('gl_edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>

            </td>
        </tr>

        @endforeach
    </tbody>

</table>
