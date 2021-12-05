<form action="{{ route('vendor_onboard_accept_rejoin') }}" id="updateForm_rejoin" method="post">
    <div class="modal-header">
        <h5 class="modal-title" id="rejon_modal-1">Vendor Request Accept For Rejoin</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>
    <div class="modal-body">
        <input type="hidden" name="primary_id" id="primary_id" value="{{ $id }}">
        {{ csrf_field() }}

        <div class="col-md-12 form-group mb-3">
            <label for="repair_category" class="font-weight-bold">Are You Sure Want To Accept The  Vendor Request</label>
        </div>
        <div class="col-md-12 form-group">
            <label for="remarks">Cancelled Remarks</label>
              <textarea class="form-control form-control-sm" readonly style="background: #c7c7c7a8;" name="cancelled_remarks" id="cancelled_remarks">{{ $pppuid_cancel_detail->cancel_remarks}}</textarea>
        </div>

        <div class="col-md-12 form-group">
            <label for="remarks">Cancelled Date and Time</label>
              <input type="text" class="form-control" readonly style="background: #c7c7c7a8;" value="{{ $pppuid_cancel_detail->cancel_date_time }}">
        </div>

        <div class="col-md-12 form-group">
            <label for="remarks">Reactive Remarks<b>(Required)</b></label>
              <textarea class="form-control form-control-sm"  required name="reactivate_remarks" id="reactivate_remarks"></textarea>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        <button class="btn btn-success ml-2" type="submit" >Accept</button>
    </div>
</form>
