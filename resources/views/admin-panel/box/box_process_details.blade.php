@if ($bikes == 'empty')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <strong class="text-capitalize">Box Installation Process Is Not Started !!</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif($bikes == 'removed')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <strong class="text-capitalize">Current Box Is Removed !!</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif($bikes == 'pending')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <strong class="text-capitalize">Box Request Is Pending !!</strong>
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
                                <td>@if ($bikes->status < '4')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                <td>
                                    @if ($bikes->status == '2')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="UploadDocuments({{$bikes->id}})">Start Process</button>
                                    @elseif($bikes->status >= '4')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewDocuments({{$bikes->id}})">View</button>
                                    @else
                                        <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Sent Bike For Install</td>
                                <td>@if ($bikes->status < '5')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                <td>
                                    @if ($bikes->status == '4')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="SentBike({{$bikes->id}})">Start Process</button>
                                    @elseif($bikes->status >= '5')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewSentBike({{$bikes->id}})">View</button>
                                    @else
                                        <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Box Installed & Upload Image</td>
                                <td>@if ($bikes->status < '6')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                <td>
                                    @if ($bikes->status == '5')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="UploadImage({{$bikes->id}})">Start Process</button>
                                    @elseif($bikes->status >= '6')
                                        <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewImage({{$bikes->id}})">View</button>
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
