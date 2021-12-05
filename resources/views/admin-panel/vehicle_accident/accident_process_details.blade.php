@if ($bikes == null)
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert">
                    <strong class="text-capitalize">Accident Process Is Not Started Yet !!</strong>
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

                @if ($bikes->status == 1)
                    <div class="alert alert-danger text-center" role="alert">
                        <strong class="text-capitalize">Waiting For Checkout !!</strong>
                    </div>
                @elseif($bikes->status == 3)
                    <div class="alert alert-danger text-center" role="alert">
                        <strong class="text-capitalize">Request Rejected !!</strong>
                    </div>
                @else
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
                                    <td>Claim Process</td>
                                    <td>@if ($bikes->status < '5')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                    <td>
                                        @if ($bikes->status == '4')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ClaimProcess({{$bikes->id}})">Start Process</button>
                                        @elseif($bikes->status >= '5')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewClaim({{$bikes->id}})">View</button>
                                        @else
                                            <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Delivery To Garage</td>
                                    <td>@if ($bikes->status < '6')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                    <td>
                                        @if ($bikes->status == '5')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="DeliveryToGarage({{$bikes->id}})">Start Process</button>
                                        @elseif($bikes->status >= '6')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewDelivery({{$bikes->id}})">View</button>
                                        @else
                                            <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Total Loss Or Repairable</td>
                                    <td>@if ($bikes->status < '7')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                    <td>
                                        @if ($bikes->status == '6')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="LossOrRepair({{$bikes->id}})">Start Process</button>
                                        @elseif($bikes->status >= '7')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewLossRepair({{$bikes->id}})">View</button>
                                        @else
                                            <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                @if ($bikes->loss_or_repair != 2)
                                <tr>
                                    <td>5</td>
                                    <td>Total Loss Claim Submission</td>
                                    <td>@if ($bikes->status < '8')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                    <td>
                                        @if ($bikes->status == '7')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="LossClaim({{$bikes->id}})">Start Process</button>
                                        @elseif($bikes->status >= '8')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewLossClaim({{$bikes->id}})">View</button>
                                        @else
                                            <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Total Loss Bike Cancellation</td>
                                    <td>@if ($bikes->status < '9')<span class="badge badge-danger">Pending</span>@else<span class="badge badge-success">Completed</span>@endif</td>
                                    <td>
                                        @if ($bikes->status == '8')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="LossBikeCancel({{$bikes->id}},{{$bikes->bike_id}})">Start Process</button>
                                        @elseif($bikes->status >= '9')
                                            <button class="btn btn-primary btn-sm btn-start" type="button" onclick="ViewCancel({{$bikes->id}})">View</button>
                                        @else
                                            <button disabled="" class="btn btn-primary btn-sm btn-start" type="button">Process Pending</button>
                                        @endif
                                    </td>
                                    <td></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endif
