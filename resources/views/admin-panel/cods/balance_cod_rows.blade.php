<?php
$total_pending_amount = 0;
$total_paid_amount = 0;
$total_previous_amount = 0;
$total_pending_amount = $rider->total;

$now_cod = $cods->where('passport_id',$rider->passport_id)->where('status','1')->sum('amount');
$adj_req_t = $codadjust->where('passport_id','=',$rider->passport_id)->where('status','=','2')->sum('amount');
$close_m = $close_month->where('passport_id','=',$rider->passport_id)->sum('close_month_amount');
$now_cods = $cods->where('passport_id',$rider->passport_id)->where('status','1')->sortByDesc('id')->first();

if($now_cod != null){
    $total_paid_amount = $now_cod;
}
if($close_m != null){
    $total_paid_amount = $total_paid_amount+$close_m;
}

if($adj_req_t != null){
    $total_paid_amount = $total_paid_amount+$adj_req_t;
}
$remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
?>

@if ($amt == 'Balancebelow500Cod')
    @if ($remain_amount > '0' && $remain_amount < '500')
        <tr>
            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
            <td>{{ $rider->rider_id }}</td>
            <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
            <td>{{ $remain_amount }}</td>
            <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
            <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
            <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_add_btn" data-toggle="modal" data-target="#CODFollowUpAddModalCenter"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}">
                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                </button>
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_list_btn"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}"
                    >
                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ count($rider->follow_ups) }} )
                </button>
            </td>
        </tr>
    @endif
@endif

@if ($amt == 'BalanceAbove500Cod')
    @if ($remain_amount >= '500' && $remain_amount < '1000')
        <tr>
            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
            <td>{{ $rider->rider_id }}</td>
            <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
            <td>{{ $remain_amount }}</td>
            <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
            <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
            <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_add_btn" data-toggle="modal" data-target="#CODFollowUpAddModalCenter"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}">
                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                </button>
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_list_btn"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}"
                    >
                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ count($rider->follow_ups) }} )
                </button>
            </td>
        </tr>
    @endif
@endif

@if ($amt == 'BalanceAbove1000Cod')
    @if ($remain_amount >= '1000' && $remain_amount < '1500')
        <tr>
            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
            <td>{{ $rider->rider_id }}</td>
            <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
            <td>{{ $remain_amount }}</td>
            <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
            <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
            <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_add_btn" data-toggle="modal" data-target="#CODFollowUpAddModalCenter"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}">
                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                </button>
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_list_btn"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}"
                    >
                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ count($rider->follow_ups) }} )
                </button>
            </td>
        </tr>
    @endif
@endif

@if ($amt == 'BalanceAbove1500Cod')
    @if ($remain_amount >= '1500' && $remain_amount < '2000')
        <tr>
            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
            <td>{{ $rider->rider_id }}</td>
            <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
            <td>{{ $remain_amount }}</td>
            <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
            <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
            <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_add_btn" data-toggle="modal" data-target="#CODFollowUpAddModalCenter"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}">
                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                </button>
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_list_btn"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}"
                    >
                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ count($rider->follow_ups) }} )
                </button>
            </td>
        </tr>
    @endif
@endif

@if ($amt == 'BalanceAbove2000Cod')
    @if ($remain_amount >= '2000' && $remain_amount < '2500')
        <tr>
            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
            <td>{{ $rider->rider_id }}</td>
            <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
            <td>{{ $remain_amount }}</td>
            <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
            <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
            <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_add_btn" data-toggle="modal" data-target="#CODFollowUpAddModalCenter"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}">
                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                </button>
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_list_btn"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}"
                    >
                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ count($rider->follow_ups) }} )
                </button>
            </td>
        </tr>
    @endif
@endif

@if ($amt == 'BalanceAbove2500Cod')
    @if ($remain_amount >= '2500')
        <tr>
            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
            <td>{{ $rider->rider_id }}</td>
            <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
            <td>{{ $remain_amount }}</td>
            <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
            <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
            <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_add_btn" data-toggle="modal" data-target="#CODFollowUpAddModalCenter"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}">
                    <span class="ul-btn__icon"><i class="i-add"></i></span> Add
                </button>
            </td>
            <td>
                <button
                    type="button"
                    class="btn btn-sm btn-block col  btn-info btn-icon m-1 follow_up_list_btn"
                    data-rider_id="{{ $rider->rider_id ?? 'NA' }}"
                    data-rider_name="{{ $rider->passport->personal_info->full_name ?? 'NA' }}"
                    data-passport_id="{{ $rider->passport_id }}"
                    data-deliveroo_upload_id="{{ $rider->id }}"
                    data-rider_ppuid="{{ $rider->passport->pp_uid ?? 'NA' }}"
                    data-rider_zds="{{ $rider->passport->zds_code->zds_code ?? 'NA' }}"
                    data-rider_phone="{{ $rider->passport->sim->telecome->account_number ?? 'NA' }}"
                    >
                    <span class="ul-btn__icon"><i class="i-Sidebar-Window"></i></span> Calls ( {{ count($rider->follow_ups) }} )
                </button>
            </td>
        </tr>
    @endif
@endif
