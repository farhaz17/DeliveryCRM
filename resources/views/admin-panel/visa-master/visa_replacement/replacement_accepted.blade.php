<div class="table-responsive">
    <table class="table table-sm table-hover table-striped text-11 data_table_cls" id="datatable-6" >
        <thead class="thead-dark">
        <tr class="t-row">
            <th scope="col">Name</th>
            <th scope="col">Passport No</th>
            <th scope="col">PPUID</th>
            <th scope="col">Remarks</th>
            <th scope="col">Request Sent at</th>
            <th scope="col">Sent by</th>
            <th scope="col">HR Request</th>

            {{-- <th scope="col">Action</th> --}}
        </tr>
        </thead>
        <tbody>
         @foreach($acc as $res)
            <tr>
                <td>{{isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:""}}</td>
                <td>{{ isset($res->passport->passport_no)?$res->passport->passport_no:""}}</td>
                <td>{{ isset($res->passport->pp_uid)?$res->passport->pp_uid:""}}</td>
                <td>{{ isset($res->remarks)?$res->remarks:""}}</td>
                <td>{{ isset($res->created_at)?$res->created_at:""}}</td>
                <td>{{ isset($res->user_detail->name)?$res->user_detail->name:""}}</td>
                <td>
                    @if ($res->hr_reqest=='0')

                            <span class="badge badge-pill badge-danger m-2">No</span>
                    @else

                    <span class="badge badge-pill badge-success m-2">Yes</span>
                            @endif

                </td>
                {{-- <td>{{ isset($res->accept_detail->name)?$res->accept_detail->name:""}}</td> --}}


         </tr>
        @endforeach

        </tbody>
    </table>
</div>
