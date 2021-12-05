@if ($bikes == 'empty')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <strong class="text-capitalize">Food Permit Process Is Not Started !!</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Process</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                <th scope="col">Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Upload Documents</td>
                                <td>@if ($bikes->status < '2')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                <td>
                                    @if ($bikes->status == '1')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="UploadDocuments({{$bikes->id}})">Start Process</button>
                                    @elseif($bikes->status >= '2')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewDocuments({{$bikes->id}})">View</button>
                                    @else
                                        <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Upload Food Permit</td>
                                <td>@if ($bikes->status < '3')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                <td>
                                    @if ($bikes->status == '2')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="UploadFoodPermit({{$bikes->id}})">Start Process</button>
                                    @elseif($bikes->status >= '3')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewFoodPermit({{$bikes->id}})">View</button>
                                    @else
                                        <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
