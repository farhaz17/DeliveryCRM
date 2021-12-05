<div class="row">
    <div class="col-md-12 form-group">
        <?php  $roll_array = ['Admin','RTAManage']; ?>
        @hasanyrole($roll_array)
            <a id="edit_datas" href="javascript:void(0)" style="float: right;">Edit</a>
        @endhasanyrole
        <label for="remarks" class="d-block text-left">Date</label>
        <input class="form-control" type="date" name="date" id="dat" value="{{isset($box->img_date)?$box->img_date:""}}" readonly required>
    </div>
    <div class="col-md-12 form-group">
        <label for="remarks" class="d-block text-left">Remarks</label>
        <textarea class="form-control" placeholder="Enter remarks" id="reemarks" name="remarks" rows="3" readonly>{{isset($box->img_remark)?$box->img_remark:""}}</textarea>
    </div>
    <div class="col-md-12 form-group">
        <label for="remarks" class="d-block text-left">Uploaded Image</label>
        @if(isset($box))
            @if($box->box_image!=null)
                @foreach (json_decode($box->box_image) as $attach)
                    <a href="{{Storage::temporaryUrl($attach, now()->addMinutes(5))}}" class="images_uplded" target="_blank"><strong style="color: #000000">View Attachment </strong></a><span>|</span>
                @endforeach
            @else
                <strong class="images_uplded">NO Images Uploaded</strong>
            @endif
        @endif
        <input class="form-control-file form-control-sm" style="display: none" id="file_name1"  name="image[]" multiple type="file" />
    </div>
</div>
<input type="hidden" name="id" value="{{ $box->id }}">

<script>
    $('#edit_datas').click(function(){
        $('#dat').attr('readonly', false);
        $('#reemarks').attr('readonly', false);
        $('#file_name1').show();
        $('.images_uplded').hide();
        $('#box_img_btn').show();
    });
</script>
