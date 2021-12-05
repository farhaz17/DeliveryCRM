@if($profitablity_indicator == 1)

    <label for="setting_name">Excellent</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-success" id="highest-is-profitable-excellent">></span></div>
        <input class="form-control text-12 border-success" type="number" name="column_settings[{{$column_name}}][excellent]" placeholder="Value" aria-label="Value" aria-describedby="highest-is-profitable-excellent" required>
    </div>
    <label for="setting_name">Very Good</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-secondary" id="highest-is-profitable-excellent">></span></div>
        <input class="form-control text-12 border-secondary" type="number" name="column_settings[{{$column_name}}][very_good]" placeholder="Value" aria-label="Value" aria-describedby="highest-is-profitable-very_good" required>
    </div>
    <label for="setting_name">Good</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-warning" id="highest-is-profitable-excellent">></span></div>
        <input class="form-control text-12 border-warning" type="number" name="column_settings[{{$column_name}}][good]" placeholder="Value" aria-label="Value" aria-describedby="highest-is-profitable-good" required>
    </div>
    <label for="setting_name">Bad</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-danger" id="highest-is-profitable-excellent">></span></div>
        <input class="form-control text-12 border-danger" type="number" name="column_settings[{{$column_name}}][bad]" placeholder="Value" aria-label="Value" aria-describedby="highest-is-profitable-bad" required>
    </div>
    <label for="setting_name">Very Bad</label>

@elseif($profitablity_indicator == 2)

    <label for="setting_name">Excellent</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-success" id="lowest-is-profitable-excellent"><</span></div>
        <input class="form-control text-12 border-success" type="number" name="column_settings[{{$column_name}}][excellent]" placeholder="Value" aria-label="Value" aria-describedby="lowest-is-profitable-excellent" required>
    </div>
    <label for="setting_name">Very Good</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-secondary" id="lowest-is-profitable-very_good"><</span></div>
        <input class="form-control text-12 border-secondary" type="number" name="column_settings[{{$column_name}}][very_good]" placeholder="Value" aria-label="Value" aria-describedby="lowest-is-profitable-very_good" required>
    </div>
    <label for="setting_name">Good</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-warning" id="lowest-is-profitable-good"><</span></div>
        <input class="form-control text-12 border-warning" type="number" name="column_settings[{{$column_name}}][good]" placeholder="Value" aria-label="Value" aria-describedby="lowest-is-profitable-good" required>
    </div>
    <label for="setting_name">Bad</label>
    <div class="input-group input-group-sm mb-3">
        <div class="input-group-prepend"><span class="input-group-text border-danger" id="lowest-is-profitable-bad"><</span></div>
        <input class="form-control text-12 border-danger" type="number" name="column_settings[{{$column_name}}][bad]" placeholder="Value" aria-label="Value" aria-describedby="lowest-is-profitable-bad" required>
    </div>
    <label for="setting_name">Very Bad</label>

@endif
