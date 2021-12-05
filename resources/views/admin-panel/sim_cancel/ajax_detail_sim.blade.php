<div class="row">
            <div class="col-md-6 form-group mb-3">
                <label for="checkin_city">Sim Number</label>
                <h6>{{ $sim_cancel->sim_detail->account_number }}</h6>
            </div>

            <div class="col-md-6 form-group mb-3">
                <label for="date_and_time">Cancel Date &amp; Time </label>
                <h6>{{ $sim_cancel->created_at }}</h6>
            </div>

            <div class="col-md-6 form-group mb-3">
                <label for="date_and_time">Reason</label>
                <h6>{{ $checkout_type_array[$sim_cancel->reason_type]  }}</h6>
            </div>

            <div class="col-md-6 form-group mb-3">
                <label for="remarks">Remarks</label>
                <h6>{{ $sim_cancel->remarks }}</h6>
            </div>


</div>
