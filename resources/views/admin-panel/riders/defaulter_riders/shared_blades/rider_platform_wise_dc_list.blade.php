<label for="dc_user_id">DC List of Rider's Current Platform</label>
<select name="dc_user_id" id="dc_user_id" class="form-control form-control-sm">
    <option value=""></option>
    @foreach ($platform_users as $user)
    <option value="{{ $user->id }}">{{ ucFirst($user->name ?? "") }}</option>
    @endforeach
</select>
<script>
    $('#dc_user_id').select2({
        placeholder: "Select DRCs user"
    });
</script>
