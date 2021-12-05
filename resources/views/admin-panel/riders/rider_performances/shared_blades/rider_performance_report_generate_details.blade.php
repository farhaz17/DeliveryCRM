<div class="accordion" id="accordionRightIcon">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="ul-collapse__icon--size ul-collapse__right-icon mb-0">
                <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false">
                    <span><i class="i-Eye ul-accordion__font"></i></span>
                    Click to view Performance Settings
                </a>
            </h6>
        </div>
        <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon" style="">
            <div class="card-body">
                @foreach ($performance_setting['column_settings'] as $column_setting)
                    <div class="row border-bottom mb-2">
                        <div class="title col-12 text-uppercase">
                            <label class="checkbox checkbox-outline-success">
                                <input type="checkbox" class="column_checkboxes" checked="checked" value="{{ $column_setting['name'] }}">
                                <span> Column Settings <b>( {{ $column_setting['label'] }} )</b></span><span class="checkmark"></span>
                                |  Values should be in between <b>( {{ $column_setting['lowest_value'] }} </b> and  <b> {{ $column_setting['highest_value'] }} )</b>
                            </label>
                        </div>
                        <div class="col-md-2 form-group mb-3">
                            <label for="profitability_indicator">Profitability Indicator</label>
                            <input class="form-control form-control-sm text-12" value="{{ $column_setting['profitability_indicator'] == 1 ? 'Highest is Profitable' : 'Lowest is Profitable'}}" disabled>
                        </div>
                        <div class="col-md-10 row" style="display: grid; grid-template-columns: 8% 12% 8% 12% 8% 12% 8% 12% 8% 12%; grid-gap: 10px; text-align: center; margin-top: 20px;" id="completed_orders_profitability_indicator">
                        <label for="setting_name">Excellent</label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend"><span class="input-group-text border-success" id="highest-is-profitable-excellent">{{ $column_setting['profitability_indicator'] == 2 ? "<" : ">" }}</span></div>
                            <input class="form-control text-12 border-success" value="{{ $column_setting['excellent'] }}" disabled>
                        </div>
                        <label for="setting_name">Very Good</label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend"><span class="input-group-text border-secondary" id="lowest-is-profitable-very_good">{{ $column_setting['profitability_indicator'] == 2 ? "<" : ">" }}</span></div>
                            <input class="form-control text-12 border-secondary" value="{{ $column_setting['very_good'] }}" disabled>
                        </div>
                        <label for="setting_name">Good</label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend"><span class="input-group-text border-warning" id="lowest-is-profitable-good">{{ $column_setting['profitability_indicator'] == 2 ? "<" : ">" }}</span></div>
                            <input class="form-control text-12 border-warning" value="{{ $column_setting['good'] }}" disabled>
                        </div>
                        <label for="setting_name">Bad</label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend"><span class="input-group-text border-danger" id="lowest-is-profitable-bad">{{ $column_setting['profitability_indicator'] == 2 ? "<" : ">" }}</span></div>
                            <input class="form-control text-12 border-danger" value="{{ $column_setting['bad'] }}" disabled>
                        </div>
                        <label for="setting_name">Very Bad</label>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
