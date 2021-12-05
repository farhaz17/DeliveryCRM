<select id="pass1" name="passport_id" class="form-control" >
    <option value=""  >Select option</option>
    @foreach($checked_out_pass as $pas)
        <option value="{{ $pas["id"] }}">{{ $pas["passport_no"]  }}</option>
    @endforeach
</select>
