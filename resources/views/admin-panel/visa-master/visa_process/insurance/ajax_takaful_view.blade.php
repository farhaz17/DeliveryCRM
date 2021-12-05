<table class="table table-bordered table-striped " id="takaful_table">
    <thead class="thead-dark">
    <tr class="history_table">
        <th>Name</th>
        <th>Passport No</th>
        <th>PPUID</th>
        <th>Insurance Company</th>
        <th>Member ID</th>
        <th>Company</th>
        <th>Emirates ID</th>
        <th>Network Type</th>
        <th>P.ID</th>
        <th>Effective Date</th>
        <th>Expiry Date</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($takaful as $row )
        <tr>
            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
            <td>{{isset($row->insurance_com->name)?$row->insurance_com->name:"N/A"}}</td>
            <td>{{isset($row->member_id)?$row->member_id:"N/A"}}</td>
            <td>{{isset($row->company_name->name)?$row->company_name->name:"N/A"}}</td>
            <td>{{isset($row->emirates_id)?$row->emirates_id:"N/A"}}</td>
            <td>{{isset($row->network_type)?$row->com_network->network_type:"N/A"}}</td>
            <td>{{ isset($row->pid)?$row->pid:"N/A"}}</td>
            <td>{{isset($row->effective_date)?$row->effective_date:"N/A"}}</td>
            <td>{{isset($row->expiry_date)?$row->expiry_date:'N/A'}}</td>
            <td>
                <a class="text-success mr-2" href="{{route('takaful_edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>

            </td>
        </tr>

        @endforeach
    </tbody>

</table>
