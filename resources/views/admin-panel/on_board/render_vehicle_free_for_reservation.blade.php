<div class="col-md-6 form-group">
    <label>Select Bike</label>
    <select class="form-control" id="reserve_bike_id" name="reserve_bike_id" required>

        <option value="" selected disabled>Select Bike</option>
        @foreach($bikes_detail as $bike)
            <option value="{{ $bike->id }}">{{ $bike->plate_no }}</option>
        @endforeach
    </select>
</div>

<div class="col-md-6 form-group">
    <label>Select Sim</label>
    <select class="form-control" id="reserve_sim_id" name="reserve_sim_id" required>
        <option value="" selected disabled>Select sim</option>
        @foreach($sims as $sim)
            <option value="{{ $sim->id }}">{{ $sim->account_number }}</option>
        @endforeach
    </select>
</div>
