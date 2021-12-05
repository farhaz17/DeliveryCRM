@if(empty($bike))
    <div class="p-4 text-center alert alert-danger h5">No Missing Bike in this Number!</div>
@else
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Process</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                        <th scope="col">Remarks</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>2</td>
                        <td>Police Request</td>
                        <td>@if ($bike->process < 2)<span class="badge badge-danger  p-1">Pending</span>@else<span class="badge badge-success p-1">Completed</span>@endif</td>
                        <td>
                            @if ($bike->process == 1)
                            <a class="btn btn-primary btn-sm btn-start" data-toggle="modal" data-id="{{ $bike->id }}"  data-target="#policeRequestModal" type="button" href="javascript:void(0)">Start Process</a>
                            @elseif($bike->process > 1)
                            <a class="btn btn-primary btn-sm btn-view" data-toggle="modal" data-id="2"  data-target="#viewModal" type="button" href="javascript:void(0)">View</a>
                            @elseif($bike->process < 1)
                                <button class="btn btn-primary btn-sm btn-start" type="button" disabled>Pending</button>
                            @endif
                        </td>
                        <td></td>>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Police Report</td>
                        <td>@if ($bike->process < 3)<span class="badge badge-danger p-1">Pending</span>@else<span class="badge badge-success p-1">Completed</span>@endif</td>
                        <td>
                            @if ($bike->process == 2)
                            <a class="btn btn-primary btn-sm btn-start" data-toggle="modal" data-id="{{ $bike->id }}"  data-target="#policeReportModal" type="button" href="javascript:void(0)">Start Process</a>
                            @elseif($bike->process > 2)
                            <a class="btn btn-primary btn-sm btn-view" data-toggle="modal" data-id="3"  data-target="#viewModal" type="button" href="javascript:void(0)">View</a>
                            @elseif($bike->process < 2)
                                <button class="btn btn-primary btn-sm btn-start" type="button" disabled>Pending</button>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    @if($bike->found_status != 1)
                    <tr>
                        <td>4</td>
                        <td>Insurance Claim</td>
                        <td>@if ($bike->process < 4)<span class="badge badge-danger p-1">Pending</span>@else<span class="badge badge-success p-1">Completed</span>@endif</td>
                        <td>
                            @if ($bike->process == 3)
                            <a class="btn btn-primary btn-sm btn-start" data-toggle="modal" data-id="{{ $bike->id }}"  data-target="#insuranceClaimModal" type="button" href="javascript:void(0)">Start Process</a>
                            @elseif($bike->process > 3)
                            <a class="btn btn-primary btn-sm btn-view" data-toggle="modal" data-id="4"  data-target="#viewModal" type="button" href="javascript:void(0)">View</a>
                            @elseif($bike->process < 3)
                                <button class="btn btn-primary btn-sm btn-start" type="button" disabled>Pending</button>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Payment Receive</td>
                        <td>@if ($bike->process < 5)<span class="badge badge-danger p-1">Pending</span>@else<span class="badge badge-success p-1">Completed</span>@endif</td>
                        <td>
                            @if ($bike->process == 4)
                            <a class="btn btn-primary btn-sm btn-start" data-toggle="modal" data-id="{{ $bike->id }}"  data-target="#paymentModal" type="button" href="javascript:void(0)">Start Process</a>
                            @elseif($bike->process > 4)
                            <a class="btn btn-primary btn-sm btn-view" data-toggle="modal" data-id="5"  data-target="#viewModal" type="button" href="javascript:void(0)">View</a>
                            @elseif($bike->process < 4)
                                <button class="btn btn-primary btn-sm btn-start" type="button" disabled>Pending</button>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Vehicle Cancellation</td>
                        <td>@if ($bike->process < 6)<span class="badge badge-danger p-1">Pending</span>@else<span class="badge badge-success p-1">Completed</span>@endif</td>
                        <td>
                            @if ($bike->process == 5)
                            <a class="btn btn-primary btn-sm btn-start" data-toggle="modal" data-id="{{ $bike->id }}"  data-target="#cancellationModal" type="button" href="javascript:void(0)">Start Process</a>
                            @elseif($bike->process > 5)
                            <a class="btn btn-primary btn-sm btn-view" data-toggle="modal" data-id="6"  data-target="#viewModal" type="button" href="javascript:void(0)">View</a>
                            @elseif($bike->process < 5)
                                <button class="btn btn-primary btn-sm btn-start" type="button" disabled>Pending</button>
                            @endif
                        </td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
