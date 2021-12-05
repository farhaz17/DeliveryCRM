    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <ul class="nav nav-tabs small" id="myTab" role="tablist">
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link active" id="AllSelectedDateCodsTab" data-toggle="tab" href="#AllSelectedDateCods" role="tab" aria-controls="AllSelectedDateCods" aria-selected="true">All Cods ( {{$cods->count()}} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="ActiveTalabatRiderCodsTab" data-toggle="tab" href="#ActiveTalabatRiderCods" role="tab" aria-controls="ActiveTalabatRiderCods" aria-selected="true">All Active Talabat Rider Cods ( {{$active_talabat_rider_cods->count()}} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="ExTalabatRiderCodsTab" data-toggle="tab" href="#ExTalabatRiderCods" role="tab" aria-controls="ExTalabatRiderCods" aria-selected="true">All Ex Talabat Rider Cods ( {{$ex_talabat_rider_cods->count()}} )</a>
        </li>
        <li class="nav-item">
            {{-- adding new tabs please follow the tab id and table id with endingTable with the following naming convensions  --}}
            <a class="nav-link" id="NoTalabatRiderCodsTab" data-toggle="tab" href="#NoTalabatRiderCods" role="tab" aria-controls="NoTalabatRiderCods" aria-selected="true">All No Talabat / No DC Rider Cods ( {{$no_talabat_rider_cods->count()}} )</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="AllSelectedDateCods" role="tabpanel" aria-labelledby="AllSelectedDateCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="AllSelectedDateCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                            <th class="text-right">Cash Received</th>
                            <th class="text-right">Bank Received</th>
                            <th class="text-right">Net Balance</th>
                            @endif
                            <th class="text-right">Follow</th>
                            <th class="text-left">Ups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                            @php
                                $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                $net_balance = $cod->current_day_balance - ($cash + $bank);
                            @endphp
                            <td class="text-right" >{{ number_format($cash ,2) }}</td>
                            <td class="text-right" >{{ number_format($bank ,2) }}</td>
                            <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                            <td class="text-right">
                                <!-- Button trigger modal -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-block col btn-info btn-icon m-1 follow_up_add_btn"
                                        data-toggle="modal"
                                        data-target="#CODFollowUpAddModalCenter"
                                        data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                        data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                        data-passport_id="{{ $cod->passport_id }}"
                                        data-talabat_cod_id="{{ $cod->id }}"
                                        data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                        data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                        data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                        data-button_id = {{ $city_wise_button_id }}
                                        data-active_tab_id = "#AllSelectedDateCods"
                                    >
                                        <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                                    </button>
                            </td>
                            <td class="text-right">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-block col  btn-{{ get_follow_up_call_count_wise_color_class($cod->follow_ups_count ?? 0) }} btn-icon m-1 follow_up_list_btn"
                                        data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                        data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                        data-passport_id="{{ $cod->passport_id }}"
                                        data-talabat_cod_id="{{ $cod->id }}"
                                        data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                        data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                        data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                        data-button_id = {{ $city_wise_button_id }}
                                        >
                                        <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ $cod->follow_ups_count }} )
                                    </button>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="ActiveTalabatRiderCods" role="tabpanel" aria-labelledby="ActiveTalabatRiderCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="ActiveTalabatRiderCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left filtering_column">DC</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                            <th class="text-right">Cash Received</th>
                            <th class="text-right">Bank Received</th>
                            <th class="text-right">Net Balance</th>
                            @endif
                            <th class="text-right">Follow</th>
                            <th class="text-left">Ups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($active_talabat_rider_cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >
                                {{
                                    $cod->passport->assign_to_dcs
                                    ->where('status', 1)
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                    ??
                                    $cod->passport->assign_to_dcs
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                }}
                            </td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                            @php
                                $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                $net_balance = $cod->current_day_balance - ($cash + $bank);
                            @endphp
                            <td class="text-right" >{{ number_format($cash ,2) }}</td>
                            <td class="text-right" >{{ number_format($bank ,2) }}</td>
                            <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                            <td class="text-right">
                                <!-- Button trigger modal -->
                                <button
                                    type="button"
                                    class="btn btn-sm btn-block col btn-info btn-icon m-1 follow_up_add_btn"
                                    data-toggle="modal"
                                    data-target="#CODFollowUpAddModalCenter"
                                    data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                    data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                    data-passport_id="{{ $cod->passport_id }}"
                                    data-talabat_cod_id="{{ $cod->id }}"
                                    data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                    data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                    data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                    data-button_id = {{ $city_wise_button_id }}
                                    data-active_tab_id = "#ActiveTalabatRiderCods"
                                    >
                                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                                </button>
                            </td>
                            <td class="text-right">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-block col btn-{{ get_follow_up_call_count_wise_color_class($cod->follow_ups_count ?? 0) }} btn-icon m-1 follow_up_list_btn"
                                    data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                    data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                    data-passport_id="{{ $cod->passport_id }}"
                                    data-talabat_cod_id="{{ $cod->id }}"
                                    data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                    data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                    data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                    data-button_id = {{ $city_wise_button_id }}
                                    >
                                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ $cod->follow_ups_count }} )
                                </button>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="ExTalabatRiderCods" role="tabpanel" aria-labelledby="ExTalabatRiderCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="ExTalabatRiderCodsTable">
                    <thead>
                        <tr>
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            <th class="text-left filtering_column">DC</th>
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                            <th class="text-right">Cash Received</th>
                            <th class="text-right">Bank Received</th>
                            <th class="text-right">Net Balance</th>
                            @endif
                            <th class="text-right">Follow</th>
                            <th class="text-left">Ups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ex_talabat_rider_cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            <td class="text-left" >
                                {{
                                    $cod->passport->assign_to_dcs
                                    ->where('status', 1)
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                    ??
                                    $cod->passport->assign_to_dcs
                                    ->whereIn('platform_id', [15,34,41])
                                    ->first()
                                    ->user_detail->name
                                }}
                            </td>
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                            @php
                                $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                $net_balance = $cod->current_day_balance - ($cash + $bank);
                            @endphp
                            <td class="text-right" >{{ number_format($cash ,2) }}</td>
                            <td class="text-right" >{{ number_format($bank ,2) }}</td>
                            <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                            <td class="text-right">
                                <!-- Button trigger modal -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-block col btn-info btn-icon m-1 follow_up_add_btn"
                                        data-toggle="modal"
                                        data-target="#CODFollowUpAddModalCenter"
                                        data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                        data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                        data-passport_id="{{ $cod->passport_id }}"
                                        data-talabat_cod_id="{{ $cod->id }}"
                                        data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                        data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                        data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                        data-button_id = {{ $city_wise_button_id }}
                                        data-active_tab_id = "#ExTalabatRiderCods"
                                    >
                                        <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                                    </button>
                            </td>
                            <td class="text-right">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-block col btn-{{ get_follow_up_call_count_wise_color_class($cod->follow_ups_count ?? 0) }} btn-icon m-1 follow_up_list_btn"
                                    data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                    data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                    data-passport_id="{{ $cod->passport_id }}"
                                    data-talabat_cod_id="{{ $cod->id }}"
                                    data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                    data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                    data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                    data-button_id = {{ $city_wise_button_id }}
                                    >
                                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ $cod->follow_ups_count }} )
                                </button>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="NoTalabatRiderCods" role="tabpanel" aria-labelledby="NoTalabatRiderCodsTab">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-11" id="NoTalabatRiderCodsTable">
                    <thead>
                        <tr class="{{ get_follow_up_call_count_wise_color_class($cod->follow_ups_count ?? 0) }}">
                            <th class="text-left">RiderId</th>
                            <th class="text-left">Name</th>
                            {{-- <th class="text-left filtering_column">DC</th> --}}
                            <th class="text-left">PPUID</th>
                            <th class="text-left">ZDS</th>
                            <th class="text-left">Phone</th>
                            <th class="text-right">Previous Day Pending</th>
                            <th class="text-right">Cash Deposit</th>
                            <th class="text-right">Previous Day Balance</th>
                            <th class="text-right">Current Adjustment</th>
                            <th class="text-right">Current COD</th>
                            <th class="text-right">Tips</th>
                            <th class="text-right">Current Balance</th>
                            @if($adjustment_type == 1)
                            <th class="text-right">Cash Received</th>
                            <th class="text-right">Bank Received</th>
                            <th class="text-right">Net Balance</th>
                            @endif
                            <th class="text-right">Follow</th>
                            <th class="text-left">Ups</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($no_talabat_rider_cods as $key => $cod)
                        <tr>
                            <td class="text-left" >{{ $cod->platform_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->personal_info->full_name ?? "NA" }}</td>
                            {{-- <td class="text-left" >{{ ucFirst($cod->passport->assign_to_dcs[0]->user_detail->name) ?? "NA" }}</td> --}}
                            <td class="text-left" >{{ $cod->passport->pp_uid ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->zds_code->zds_code ?? "NA" }}</td>
                            <td class="text-left" >{{ $cod->passport->sim->telecome->account_number ?? "NA" }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_pending ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cash_deposit ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->previous_day_balance ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_adjustment ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_cod ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->tips ,2) }}</td>
                            <td class="text-right" >{{ number_format($cod->current_day_balance ,2) }}</td>
                            @if($adjustment_type == 1)
                            @php
                                $cash = $cod->internal_cod_adjustment->cash ?? 0;
                                $bank = $cod->internal_cod_adjustment->bank ?? 0;
                                $net_balance = $cod->current_day_balance - ($cash + $bank);
                            @endphp
                            <td class="text-right" >{{ number_format($cash ,2) }}</td>
                            <td class="text-right" >{{ number_format($bank ,2) }}</td>
                            <td class="text-right" >{{ number_format($net_balance ,2) }}</td>
                            @endif
                            <td class="text-right">
                                <!-- Button trigger modal -->
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-block col btn-info btn-icon m-1 follow_up_add_btn"
                                        data-toggle="modal"
                                        data-target="#CODFollowUpAddModalCenter"
                                        data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                        data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                        data-passport_id="{{ $cod->passport_id }}"
                                        data-talabat_cod_id="{{ $cod->id }}"
                                        data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                        data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                        data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                        data-button_id = {{ $city_wise_button_id }}
                                        data-active_tab_id = "#NoTalabatRiderCods"
                                    >
                                        <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                                    </button>
                            </td>
                            <td class="text-right">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-block col btn-{{ get_follow_up_call_count_wise_color_class($cod->follow_ups_count ?? 0) }} btn-icon m-1 follow_up_list_btn"
                                        data-rider_id="{{ $cod->platform_code ?? 'NA' }}"
                                        data-rider_name="{{ $cod->passport->personal_info->full_name ?? 'NA' }}"
                                        data-passport_id="{{ $cod->passport_id }}"
                                        data-talabat_cod_id="{{ $cod->id }}"
                                        data-rider_ppuid="{{ $cod->passport->pp_uid ?? 'NA' }}"
                                        data-rider_zds="{{ $cod->passport->zds_code->zds_code ?? 'NA' }}"
                                        data-rider_phone="{{ $cod->passport->sim->telecome->account_number ?? 'NA' }}"
                                        data-button_id = {{ $city_wise_button_id }}
                                        >
                                        <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ $cod->follow_ups_count }} )
                                    </button>
                            </td>
                        </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal add Follow ups -->
    <div class="modal fade" id="CODFollowUpAddModalCenter"  role="dialog" aria-labelledby="CODFollowUpAddModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                <h5 class="modal-title" id="CODFollowUpAddModalCenterTitle">Rider COD Follow Up Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p>Rider Information</p>
                    <table class="table table-sm table-striped text-11">
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td colspan="4" id="rider_name"></td>
                        </tr>
                        <tr>
                            <td>RiderId</td>
                            <td>:</td>
                            <td id="rider_id"></td>
                            <td>PPUID</td>
                            <td>:</td>
                            <td id="rider_ppuid"></td>
                        </tr>
                        <tr>
                            <td>ZDS</td>
                            <td>:</td>
                            <td id="rider_zds"></td>
                            <td>Phone</td>
                            <td>:</td>
                            <td id="rider_phone"></td>
                        </tr>
                    </table>
                    <p>COD Follow Up form</p>
                    <input type="hidden" name="passport_id" id="passport_id">
                    <input type="hidden" name="talabat_cod_id" id="talabat_cod_id">
                    <input type="hidden" name="" id="city_wise_cod_button">
                    <input type="hidden" name="" id="active_tab_id">
                    <div class="form-group">
                        <label for="feedback_id" class="text-left d-block">Call feedback</label>
                        <select class="form-control form-control-sm" name="feedback_id" id="feedback_id">
                            <option value="">Select A Call feedback</option>
                            <option value="1">Will deposit today</option>
                            <option value="2">Will deposit tomorrow</option>
                            <option value="3">Messaged on whatsapp</option>
                            <option value="4">Others specify</option>
                            <option value="5">Paid</option>
                            <option value="6">Not Received</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="remarks" class="d-block text-left">Remarks</label>
                        <textarea class="form-control" placeholder="Enter follow up remarks" id="remarks" name="remarks" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="follow_up_save_btn">Save Follow Up</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <!-- Modal Follow ups list -->
    <div class="modal fade" id="CODFollowUpListModalCenter"  role="dialog" aria-labelledby="CODFollowUpListModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                <h5 class="modal-title" id="CODFollowUpListModalCenterTitle">Rider COD Follow Up List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <p>Rider Information</p>
                    <table class="table table-sm table-striped text-11">
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td colspan="4" id="follow_up_rider_name"></td>
                        </tr>
                        <tr>
                            <td>RiderId</td>
                            <td>:</td>
                            <td id="follow_up_rider_id"></td>
                            <td>PPUID</td>
                            <td>:</td>
                            <td id="follow_up_rider_ppuid"></td>
                        </tr>
                        <tr>
                            <td>ZDS</td>
                            <td>:</td>
                            <td id="follow_up_rider_zds"></td>
                            <td>Phone</td>
                            <td>:</td>
                            <td id="follow_up_rider_phone"></td>
                        </tr>
                    </table>
                    <p>COD Follow Up List</p>
                    <div class="table-responsive" id="followUpCallListHolder">
                        followUpCallListHolder
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-sm btn-primary" id="follow_up_save_btn">Save Follow Up</button> --}}
                </div>
            </form>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.follow_up_add_btn').click(function(){
            $('#rider_id').text($(this).attr('data-rider_id'))
            $('#rider_name').text($(this).attr('data-rider_name'))
            $('#rider_ppuid').text($(this).attr('data-rider_ppuid'))
            $('#rider_zds').text($(this).attr('data-rider_zds'))
            $('#rider_phone').text($(this).attr('data-rider_phone'))
            $('#passport_id').val($(this).attr('data-passport_id'))
            $('#talabat_cod_id').val($(this).attr('data-talabat_cod_id'))
            $('#city_wise_cod_button').val($(this).attr('data-button_id'))
            $('#active_tab_id').val($(this).attr('data-active_tab_id'))
        });
    </script>
    <script>
        $('.follow_up_list_btn').click(function(){
            $('#follow_up_rider_id').text($(this).attr('data-rider_id'))
            $('#follow_up_rider_name').text($(this).attr('data-rider_name'))
            $('#follow_up_rider_ppuid').text($(this).attr('data-rider_ppuid'))
            $('#follow_up_rider_zds').text($(this).attr('data-rider_zds'))
            $('#follow_up_rider_phone').text($(this).attr('data-rider_phone'))
            var talabat_cod_id = $(this).attr('data-talabat_cod_id')
            var url = "{{ route('talabat_cod_follow_up_calls') }}";
            $.ajax({
                url,
                method: 'GET',
                data: { talabat_cod_id },
                success: function(response){
                    $('#followUpCallListHolder').empty()
                    $('#followUpCallListHolder').append(response.html)
                    $('#CODFollowUpListModalCenter').modal('show')
                }
            });
        });
    </script>
    <script>
        $('#feedback_id').select2({
            placeholder: "Select A feed Back",
            width: '100%',
        });
    </script>
    <script>
        $('#follow_up_save_btn').click(function(){
            var passport_id = $('#passport_id').val();
            var talabat_cod_id = $('#talabat_cod_id').val();
            var feedback_id = $('#feedback_id').val();
            var remarks = $('#remarks').val();
            var _token = "{{ csrf_token() }}";
            var url = "{{ route('talabat_cod_follow_ups.store') }}";
            var city_wise_cod_button = '#' + $('#city_wise_cod_button').val();
            var active_tab_id = $('#active_tab_id').val();
            $.ajax({
                url,
                method: 'POST',
                data: { _token, passport_id, talabat_cod_id, feedback_id, remarks },
                success: function(response){
                    tostr_display(response['alert-type'], response['message'])
                    if(response['status'] == 200){
                        $('#passport_id').val("")
                        $('#talabat_cod_id').val("")
                        $('#feedback_id').val("")
                        $('#remarks').val("")
                        $('#CODFollowUpAddModalCenter').modal('hide')
                        city_wise_cod_button.click()
                        // .then(function(){
                        // // active_tab_id.click()
                        // })
                    }
                }
            });
        })
    </script>
    <script>
        $(document).ready(function () {
            'use-strict',
            $('#AllSelectedDateCodsTable, #ActiveTalabatRiderCodsTable, #ExTalabatRiderCodsTable, #NoTalabatRiderCodsTable').DataTable({
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                        filtering_columns.push(v.cellIndex)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'City Wise Talabat COD Summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
            });
        });
    </script>
    <script>
        function tostr_display(type, message){
            switch(type){
                case 'info':
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
            }
        }
    </script>

