@if($employee_id=="1")

    @foreach($company as $com)
        <div class="col-md-4 text-left ">
            <div class="form-check-inline">
                <label class="radio radio-outline-primary">
                    <input type="radio" class="agreement_full_name" value="{{$com->id }}" name="agreement_not_employee_name"><span>{{$com->name}} ({{  $com->total_apply_visa_company_not_employee() }}) </span><span class="checkmark"></span>
                </label>
            </div>
        </div>
    @endforeach


@elseif($employee_id=="2")

@foreach($company as $com)
    <div class="col-md-4 text-left ">
        <div class="form-check-inline">
            <label class="radio radio-outline-primary">
                <input type="radio" class="agreement_full_name" value="{{$com->id }}" name="agreement_full_time_name"><span>{{$com->name}} ({{  $com->total_apply_visa_company_full_time() }}) </span><span class="checkmark"></span>
            </label>
        </div>
    </div>
@endforeach

@else
    @foreach($company as $com)
        <div class="col-md-4 text-left ">
            <div class="form-check-inline">
                <label class="radio radio-outline-primary">
                    <input type="radio" class="agreement_part_name" value="{{$com->id }}" name="agreement_part_time_name"><span>{{$com->name}} ({{  $com->total_apply_visa_company_part_time() }}) </span><span class="checkmark"></span>
                </label>
            </div>
        </div>
    @endforeach
@endif
