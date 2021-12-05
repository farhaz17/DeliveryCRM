<h4 class="card-title mb-3"> <span class="badge badge-primary m-2">Visa Cancel Approval</span></h4>
<table class="display table table-striped table-bordered table-sm text-10" id="datatable-approval" width="100%">
    <thead>
    <tr>

        <th scope="col">Name</th>
        <th scope="col">Passport No</th>
        <th scope="col">PPUID</th>
        <th scope="col">Cancellation Date & Time</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($visa_cancel_app as $row)
        <tr>
            <td> {{$row->passport->personal_info->full_name}}</td>
            <td> {{$row->passport->passport_no}}</td>
            <td> {{$row->passport->pp_uid}}</td>
            <td> {{$row->created_at}}</td>
            <td>
                <a class="btn btn-primary btn-sm start-visa" href="{{ url('cancel_visa') }}?passport_id={{ $row->passport->passport_no }}" target="_blank">Cancel Process</a>
            </td>
        </tr>

    @endforeach



    </tbody>
</table>
