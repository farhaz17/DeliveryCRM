<div class="row">
    <div class="col-md-12 form-group">
        <label for="">Upload Police Report</label>
        @if(isset($documents))
            @if($documents->police_report_attachment!=null)
            <br>
                @foreach (json_decode($documents->police_report_attachment) as $attach)
                    <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}"  target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                @endforeach
            @else
                <input type="file" name="police[]" multiple class="form-control-file form-control-sm" id="" >
            @endif
        @endif
    </div>
    <div class="col-md-12 form-group">
        <label for="">Recived Documents</label><br>
        <label class="checkbox checkbox-outline-primary text-10">
            <input type="checkbox" class="bike_checkbox" id="polices" name="polices" value="1" @if($documents->police_report_attachment!=null) checked @endif><span></span><span class="checkmark"></span>Police Report
        </label>
        <label class="checkbox checkbox-outline-primary text-10">
            <input type="checkbox" class="bike_checkbox" name="eid" value="1"><span></span><span class="checkmark"></span>Emirates ID
        </label>
        <label class="checkbox checkbox-outline-primary text-10">
            <input type="checkbox" class="bike_checkbox" name="license" value="1"><span></span><span class="checkmark"></span>Driving License
        </label>
        <label class="checkbox checkbox-outline-primary text-10">
            <input type="checkbox" class="bike_checkbox" name="passport" value="1"><span></span><span class="checkmark"></span>Passport
        </label>
    </div>
    <div class="col-md-12 form-group repair">
        <label for="">Repair Charge</label>
        <input type="number" name="salary" class="form-control form-control-sm" id="">
    </div>
</div>

<script>
    $(document).ready(function() {
        if($('#polices').is(":checked")) {
                $('.repair').hide();
            }
        $('#polices').change(function(){
            if($(this).is(":checked")) {
                $('.repair').hide();
            }else{
                $('.repair').show();
            }
        });
    });
</script>
