<label for="repair_category">Visa Steps </label>
<select id="visa_steps" name="visa_step" class="form-control  form-control-sm">
    <option value="" selected disabled>Select Visa Step</option>
    {{-- @if(!empty($visa_steps))
    sizeof($assigned_detail)=='0' --}}

    @empty ($visa_steps)
            @foreach($visa_steps2 as $res)
            <option value="{{$res->id}}">{{$res->step_name}}</option>
            @endforeach
    @else

    @foreach($visa_steps as $res)
    <option value="{{$res->id}}">{{$res->step_name}}</option>

    @endforeach

@endempty
</select>
<script>
     $('#visa_steps').select2({
                    placeholder: 'Select an option'
                });
</script>


<script>
     $(document).ready(function(e) {
        $("#visa_steps").change(function(){
            var textval = $(":selected",this).val();
            var token = $("input[name='_token']").val();


            var passport_number = $("input[name='passport_number']").val();


            $.ajax({
                        url: "{{ route('get_assign_amount') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{textval:textval,_token:token,passport_number:passport_number},

                        success: function (response) {
                            $('input[name=amount]').val('');
                            $('input[name=amount]').val(response.data);

                        }
                    });



        })
    });

</script>
