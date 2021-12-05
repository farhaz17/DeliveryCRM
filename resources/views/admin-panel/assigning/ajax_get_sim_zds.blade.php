<select id="pass3" name="passport_id" class="form-control" >
    <option value=""  >Select option</option>
    @foreach($checked_out_pass as $zds)
        <option value="{{$zds["id"]}}">{{$zds["zds_code"]}}</option>
    @endforeach
</select>

