<div class="row">
    <div class="col-md-12 form-group">
        <label for="remarks" class="d-block text-left">Expiry Date</label>
        <input class="form-control" type="date" name="date" id="date" value="{{isset($food->expiry_date)?$food->expiry_date:""}}" readonly>
    </div>
    <div class="col-md-8 form-group">
        <label for="remarks" class="d-block text-left">Uploaded Documents</label>
        @if(isset($food))
            @if($food->food_permit!=null)
                @foreach (json_decode($food->food_permit) as $attach)
                    <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                @endforeach
            @else
                <strong>NO Documents Uploaded</strong>
            @endif
        @endif
    </div>
</div>
