<form method="post" enctype="multipart/form-data" action="{{url('ar_balance_edit_add_balance') }}"  >
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-12 form-group mb-3">
            <label for="repair_category">Date</label>
            {{--                                        value="{{date('Y-d-m')}}"--}}
            <input class="form-control" id="date_save" required type="date" name="date_save" value="{{isset($ar_bal_edit)?$ar_bal_edit->date_saved:""}}" >

        </div>
        <div class="col-md-12   form-group mb-3">
            <label for="repair_category">Balance Type </label>
            @if(isset($ar_bal_edit))
                <input type="hidden" id="balance_type" name="balance_type" value="{{isset($ar_bal_edit)?$ar_bal_edit->id:""}}">
            @endif
            <select id="seeder_value" name="balance_type" class="form-control form-control">
                <option value="" selected disabled>Select Balance Type</option>

                @foreach($balance_types as $res)

                    @php
                        $isSelected=(isset($ar_bal_edit)?$ar_bal_edit->balance_type:"")==$res->id;
                    @endphp
                    <option value="{{$res->id}}" {{ $isSelected ? 'selected': '' }}>{{$res->name}}</option>
                @endforeach
            </select>

        </div>

        <div class="col-md-12   form-group mb-3">
            <label for="repair_category">Remarks</label>
            <textarea name="remarks" id=""  value="{{isset($ar_bal_edit)?$ar_bal_edit->remarks:""}}"  cols="30" rows="7" class="form-control"  placeholder="Enter Remarks...."></textarea>
        </div>
        <div class="col-md-12 form-group mb-3">
            <label for="repair_category">BALANCE</label>
            <input class="form-control" value="{{isset($ar_bal_edit)?$ar_bal_edit->zds_code:""}}" id="zds_code_select" type="hidden" name="zds_code_balance"/>
            <input class="form-control" value="{{isset($ar_bal_edit)?$ar_bal_edit->id:""}}" id="id" type="hidden" name="id"/>
            <input class="form-control" value="{{isset($ar_bal_edit)?$ar_bal_edit->balance:""}}" required id="balance" type="text" name="balance" placeholder="Enter Balance..." />
        </div>

        <div class="col-md-12   form-group mb-3">
            <label for="repair_category">Status Type </label>
            <select id="seeder_value" name="status_type" class="form-control form-control">
                <option value="" selected disabled>Select Status Type</option>


                    @php
                        $isSelected=(isset($ar_bal_edit)?$ar_bal_edit->status:"")=='0';
                        $isSelected2=(isset($ar_bal_edit)?$ar_bal_edit->status:"")=='1';
                    @endphp
                    <option value="0" {{ $isSelected ? 'selected': '' }}>Addition</option>
                    <option value="1" {{ $isSelected2 ? 'selected': '' }}>Substraction</option>

            </select>

        </div>

        <div class="col-md-12 input-group  form-group mb-3">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>




