@if(isset($user_codes))
<label for="repair_category">Select ZDS Code</label>
<select id="zds_code" name="zds_code" class="form-control zds_code" required >
    <option value=""  selected disabled >Select option</option>
    @foreach($user_codes as $cate)
        <option value="{{ $cate->passport_id }}">{{ $cate->zds_code  }}</option>
    @endforeach
</select>
@elseif(isset($passports))
    <label for="repair_category">Select Passport Number</label>
    <select id="passport_id" name="passport_id" class="form-control passport_id" required >
        <option value=""  selected disabled >Select option</option>
        @foreach($passports as $cate)
            <option value="{{ $cate->id }}">{{ $cate->passport_no  }}</option>
        @endforeach
    </select>
@elseif(isset($ppuid))
    <label for="repair_category">Select PPUID</label>
    <select id="ppui_id" name="ppui_id" class="form-control ppui_id" required >
        <option value=""  selected disabled >Select option</option>
        @foreach($ppuid as $cate)
            <option value="{{ $cate->id }}">{{ $cate->pp_uid  }}</option>
        @endforeach
    </select>

@endif
