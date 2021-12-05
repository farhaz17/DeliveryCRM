<div class="table-responsive">
    <table class="table table-sm table-hover table-striped text-11 data_table_cls" id="datatable-5" >
        <thead class="thead-dark">
        <tr class="t-row">
            <th scope="col">Name</th>
            <th scope="col">Passport No</th>
            <th scope="col">PPUID</th>
            <th scope="col">Remarks</th>
            <th scope="col">Request Sent at</th>
            <th scope="col">Sent by</th>
            {{-- <th scope="col">Accepted by</th> --}}
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
                {{-- <td>{{ isset($res->accept_detail->name)?$res->accept_detail->name:""}}</td> --}}
                <td>
                    @if ($res->hr_reqest=='1')
                    <button class="btn btn-success btn-icon m-1 btn-revoke" style="font-size: 12px" data-toggle="modal"
                    data-target=".bd-example-modal-lg" onclick="accept_visa_cancel({{$res->id}})"
                     type="button">
                     Accept Cancel Request
                   </button>
                    @else
                    N/A
                    @endif

                </td>

         </tr>
        @endforeach

        </tbody>
    </table>
</div>
