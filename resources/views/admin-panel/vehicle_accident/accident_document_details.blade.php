@if ($type == 1)
    <div class="row">
        <div class="col-md-8 form-group">
            <label for="remarks" class="d-block text-left">Police Report</label>
            @if(isset($accident))
                @if($accident->police_report_attachment!=null)
                    @foreach (json_decode($accident->police_report_attachment) as $attach)
                        <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                    @endforeach
                @else
                    <strong>NO Documents Uploaded</strong>
                @endif
            @endif
        </div>
        <div class="col-md-12 form-group">
            <label for="">Recived Documents</label><br>
            <label class="checkbox checkbox-outline-primary text-10">
                <input type="checkbox" class="bike_checkbox" id="polices" name="polices" value="1" @if($accident->police_report_attachment!=null) checked @endif disabled="disabled" ><span></span><span class="checkmark"></span>Police Report
            </label>
            <label class="checkbox checkbox-outline-primary text-10">
                <input type="checkbox" class="bike_checkbox" name="eid" value="1" @if($accident->emiratesid == 1) checked @endif disabled="disabled" ><span></span><span class="checkmark"></span>Emirates ID
            </label>
            <label class="checkbox checkbox-outline-primary text-10">
                <input type="checkbox" class="bike_checkbox" name="license" value="1" @if($accident->driving_license == 1) checked @endif disabled="disabled" ><span></span><span class="checkmark"></span>Driving License
            </label>
            <label class="checkbox checkbox-outline-primary text-10">
                <input type="checkbox" class="bike_checkbox" name="passport" value="1" @if($accident->passport_received == 1) checked @endif disabled="disabled" ><span></span><span class="checkmark"></span>Passport
            </label>
        </div>
        @if ($accident->police_report_received == 0)
        <div class="col-md-12 form-group">
            <label for="">Repair Charge</label>
            <input type="number" name="salary" class="form-control form-control-sm" id="" value="{{ $accident->salary }}" readonly>
        </div>
        @endif
    </div>
@elseif ($type == 2)
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="">Date</label>
            <input type="date" name="" class="form-control form-control-sm" id="" value="{{ $accident->claim_date }}" readonly>
        </div>
        <div class="col-md-8 form-group">
            <label for="remarks" class="d-block text-left">Attachment</label>
            @if(isset($accident))
                @if($accident->claim_file!=null)
                    @foreach (json_decode($accident->claim_file) as $attach)
                        <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                    @endforeach
                @else
                    <strong>NO Documents Uploaded</strong>
                @endif
            @endif
        </div>
        <div class="col-md-12 form-group">
            <label for="">Remark</label>
            <textarea name="claim_remark" id="" cols="5" class="form-control" rows="3" placeholder="Enter Remark" readonly>{{ $accident->claim_remark }}</textarea>
        </div>
    </div>
@elseif ($type == 3)
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="">Claim Number</label>
            <input type="text" class="form-control form-control-sm" value="{{ $accident->claim_number }}" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label for="">Date</label>
            <input type="date" class="form-control form-control-sm" value="{{ $accident->delivery_date }}" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label for="">Garage</label>
            <input type="text" class="form-control form-control-sm" value="{{ $accident->garage }}" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label for="">Concerned Person</label>
            <input type="text" class="form-control form-control-sm" value="{{ $accident->concerned_person }}" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label for="">Contact</label>
            <input type="text" class="form-control form-control-sm" value="{{ $accident->contact }}" readonly>
        </div>
    </div>
@elseif ($type == 4)
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="">Bike Condition</label>
            @if($accident->loss_or_repair == 1)
                <h5><b>Total Loss</b></h5>
            @elseif ($accident->loss_or_repair == 2)
                <h5><b>Repairable</b></h5>
            @endif
        </div>
        @if ($accident->loss_or_repair == 1)
            <div class="col-md-12 form-group">
                <label for="" class="d-block text-left">Offer Letter</label>
                @if(isset($accident))
                    @if($accident->offer_letter!=null)
                        @foreach (json_decode($accident->offer_letter) as $attach)
                            <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                        @endforeach
                    @else
                        <strong>NO Documents Uploaded</strong>
                    @endif
                @endif
            </div>
            <div class="col-md-12 form-group">
                <label for="" class="d-block text-left">Transfer Letter</label>
                @if(isset($accident))
                    @if($accident->transfer_letter!=null)
                        @foreach (json_decode($accident->transfer_letter) as $attach)
                            <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                        @endforeach
                    @else
                        <strong>NO Documents Uploaded</strong>
                    @endif
                @endif
            </div>
        @elseif ($accident->loss_or_repair == 2)
            <div class="col-md-12 form-group">
                <label for="">Date</label>
                <input type="date" class="form-control form-control-sm" value="{{ $accident->receive_date }}" readonly>
            </div>
            <div class="col-md-12 form-group">
                <label for="">Person</label>
                <input type="text" class="form-control form-control-sm" value="{{ $accident->person }}" readonly>
            </div>
            <div class="col-md-12 form-group">
                <label for="">Bike Condition</label>
                <textarea id="" cols="5" class="form-control" rows="3" placeholder="Enter Remark" readonly>{{ $accident->condition }}</textarea>
            </div>
        @endif
    </div>
@elseif ($type == 5)
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="">Date</label>
            <input type="date" class="form-control form-control-sm" value="{{ $accident->loss_claim_date }}" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label for="" class="d-block text-left">Uploaded Documents</label>
            @if(isset($accident))
                @if($accident->loss_claim_file!=null)
                    @foreach (json_decode($accident->loss_claim_file) as $attach)
                        <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                    @endforeach
                @else
                    <strong>NO Documents Uploaded</strong>
                @endif
            @endif
        </div>
        <div class="col-md-12 form-group">
            <label for="">Remark</label>
            <textarea name="" class="form-control" id="" cols="5" rows="3" readonly>{{ $accident->loss_claim_remark }}</textarea>
        </div>
    </div>
@elseif ($type == 6)
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="">Date</label>
            <input type="date" class="form-control form-control-sm" value="{{ $accident->cancelled_date }}" readonly>
        </div>
        <div class="col-md-12 form-group">
            <label for="">Remark</label>
            <textarea name="" class="form-control" id="" cols="5" rows="3" readonly>{{ $accident->cancelled_remark }}</textarea>
        </div>
    </div>
@endif

