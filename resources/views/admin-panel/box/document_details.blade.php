<div class="row">
    <div class="col-md-12 form-group">
        <?php  $roll_array = ['Admin','RTAManage']; ?>
        @hasanyrole($roll_array)
            <a id="edit_data" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        <label for="remarks" class="d-block text-left">Date</label>
        <input class="form-control" type="date" name="date" id="dates" value="{{isset($box->doc_date)?$box->doc_date:""}}" readonly required>
    </div>
    <div class="col-md-12 form-group">
        <label for="remarks" class="d-block text-left">Remarks</label>
        <textarea class="form-control suhail" placeholder="Enter remarks" id="remarkss" name="remarks" rows="3" readonly>{{isset($box->remark)?$box->remark:""}}</textarea>
    </div>
    <div class="col-md-8 form-group">
        <label for="remarks" class="d-block text-left">Uploaded Documents</label>
        @if(isset($box))
            @if($box->documents!=null)
                @foreach (json_decode($box->documents) as $attach)
                    <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" class="uploaded_documents" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                @endforeach
            @else
                <strong class="uploaded_documents">NO Documents Uploaded</strong>
            @endif
        @endif
        <input class="form-control-file form-control-sm" style="display: none" id="file_name"  name="documents[]" multiple type="file" />
    </div>
</div>
<input type="hidden" name="id" value={{$box->id}} >
<button type="submit" class="btn btn-sm btn-primary" style="display: none;" id="edit_btn">Update</button>

<script>
    $('#edit_data').click(function(){
        $('#dates').attr("readonly", false);
        $('#remarkss').attr("readonly", false);
        $('#file_name').show();
        $('#edit_btn').show();
        $('.uploaded_documents').hide();
    });
</script>
