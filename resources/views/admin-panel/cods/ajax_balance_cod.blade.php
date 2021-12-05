@if(count($riderProfile)>0)
<div class="table-responsive">
        <table class="table table-sm table-striped table-bordered text-11" id="datatable">
            <thead>
            <tr>
                <th></th>
                <th scope="col">Rider id</th>
                <th scope="col">Rider Name</th>
                <th scope="col">DC Name</th>
                <th scope="col">Remain COD</th>
                <th scope="col">Last Deposit Amount</th>
                <th scope="col">Last Deposit Type</th>
                <th scope="col">Last Deposit Date</th>
                {{-- <th scope="col">Days</th> --}}
                <th scope="col">Contact</th>
            </tr>
            </thead>
            <tbody>
            @foreach($riderProfile as $rider)
                <?php

                $total_pending_amount = 0;
                $total_paid_amount = 0;
                $total_previous_amount = 0;

                $total_pending_amount = $rider->total;
                // if(!empty($rider->rider_code->passport->profile->user_id)){
                    $now_cod = $cods->where('passport_id',$rider->passport_id)->where('status','1')->sum('amount');
                    $adj_req_t = $codadjust->where('passport_id','=',$rider->passport_id)->where('status','=','2')->sum('amount');
                    $close_m = $close_month->where('passport_id','=',$rider->passport_id)->sum('close_month_amount');
                    $now_cods = $cods->where('passport_id',$rider->passport_id)->where('status','1')->sortByDesc('id')->first();
                // }
                // $ticketTime = strtotime($now_cods['date']);
                // $difference = time() - $ticketTime;
                // $ak = round($difference / 86400) - 1;
                // echo $ak."<br>";

                if($now_cod != null){
                    $total_paid_amount = $now_cod;
                }
                if($close_m != null){
                    $total_paid_amount = $total_paid_amount+$close_m;
                }

                // $pre_amount = isset($rider->rider_code->passport->previous_balance->amount) ? $rider->rider_code->passport->previous_balance->amount : 0;
                // $total_pending_amount = $total_pending_amount+$pre_amount;

                if($adj_req_t != null){
                    $total_paid_amount = $total_paid_amount+$adj_req_t;
                }
                $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                ?>
                @if ($amt == 'b500')
                @if ($remain_amount > '0' && $remain_amount < '500')
                <tr>
                    <td></td>
                    @if (!$rider->passport->check_platform_code_exist->isEmpty())
                        <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4')->first(); ?>
                            <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                    @else
                            <td>N/A</td>
                    @endif
                    <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                    <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
                    <td>{{ $remain_amount }}</td>
                    <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
                    <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
                    <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
                    {{-- <td>@if ($now_cods['amount'] != null)@if ($ak == '0'){{ 'Today' }}@else{{  $ak  }} Days @endif @else N/A @endif</td> --}}
                    <td>{{ isset($rider->passport->personal_info->nat_phone) ? $rider->passport->personal_info->nat_phone : 'N/A' }}</td>
                </tr>
                @endif
                @endif

                @if ($amt == 'a500')
                @if ($remain_amount >= '500' && $remain_amount < '1000')
                <tr>
                    <td></td>
                    @if (!$rider->passport->check_platform_code_exist->isEmpty())
                        <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4')->first(); ?>
                            <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                    @else
                            <td>N/A</td>
                    @endif
                    <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                    <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
                    <td>{{ $remain_amount }}</td>
                    <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
                    <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
                    <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
                    {{-- <td>@if ($now_cods['amount'] != null)@if ($ak == '0'){{ 'Today' }}@else{{  $ak  }} Days @endif @else N/A @endif</td> --}}
                    <td>{{ isset($rider->passport->personal_info->nat_phone) ? $rider->passport->personal_info->nat_phone : 'N/A' }}</td>
                </tr>
                @endif
                @endif

                @if ($amt == 'a1000')
                @if ($remain_amount >= '1000' && $remain_amount < '1500')
                <tr>
                    <td></td>
                    @if (!$rider->passport->check_platform_code_exist->isEmpty())
                        <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4')->first(); ?>
                            <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                    @else
                            <td>N/A</td>
                    @endif
                    <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                    <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
                    <td>{{ $remain_amount }}</td>
                    <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
                    <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
                    <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
                    {{-- <td>@if ($now_cods['amount'] != null)@if ($ak == '0'){{ 'Today' }}@else{{  $ak  }} Days @endif @else N/A @endif</td> --}}
                    <td>{{ isset($rider->passport->personal_info->nat_phone) ? $rider->passport->personal_info->nat_phone : 'N/A' }}</td>
                </tr>
                @endif
                @endif

                @if ($amt == 'a1500')
                @if ($remain_amount >= '1500' && $remain_amount < '2000')
                <tr>
                    <td></td>
                    @if (!$rider->passport->check_platform_code_exist->isEmpty())
                        <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4')->first(); ?>
                            <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                    @else
                            <td>N/A</td>
                    @endif
                    <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                    <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
                    <td>{{ $remain_amount }}</td>
                    <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
                    <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
                    <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
                    {{-- <td>@if ($now_cods['amount'] != null)@if ($ak == '0'){{ 'Today' }}@else{{  $ak  }} Days @endif @else N/A @endif</td> --}}
                    <td>{{ isset($rider->passport->personal_info->nat_phone) ? $rider->passport->personal_info->nat_phone : 'N/A' }}</td>
                </tr>
                @endif
                @endif

                @if ($amt == 'a2000')
                @if ($remain_amount >= '2000' && $remain_amount < '2500')
                <tr>
                    <td></td>
                    @if (!$rider->passport->check_platform_code_exist->isEmpty())
                        <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4')->first(); ?>
                            <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                    @else
                            <td>N/A</td>
                    @endif
                    <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                    <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
                    <td>{{ $remain_amount }}</td>
                    <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
                    <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
                    <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
                    {{-- <td>@if ($now_cods['amount'] != null)@if ($ak == '0'){{ 'Today' }}@else{{  $ak  }} Days @endif @else N/A @endif</td> --}}
                    <td>{{ isset($rider->passport->personal_info->nat_phone) ? $rider->passport->personal_info->nat_phone : 'N/A' }}</td>
                </tr>
                @endif
                @endif

                @if ($amt == 'a2500')
                @if ($remain_amount >= '2500')
                <tr>
                    <td></td>
                    @if (!$rider->passport->check_platform_code_exist->isEmpty())
                        <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4')->first(); ?>
                            <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                    @else
                            <td>N/A</td>
                    @endif
                    <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                    <td>{{ isset($rider->passport->rider_dc_detail) ? $rider->passport->rider_dc_detail->user_detail->name : 'N\A' }}</td>
                    <td>{{ $remain_amount }}</td>
                    <td>{{ isset($now_cods['amount']) ? $now_cods['amount'] : 'N/A' }}</td>
                    <td>@if(isset($now_cods) )@if ($now_cods['type'] == '0'){{ 'Cash' }}@elseif($now_cods['type'] == '1'){{ 'Bank' }} @endif @else{{ 'N/A' }} @endif</td>
                    <td>{{ isset($now_cods['date']) ? $now_cods['date'] : 'N/A' }}</td>
                    {{-- <td>@if ($now_cods['amount'] != null)@if ($ak == '0'){{ 'Today' }}@else{{  $ak  }} Days @endif @else N/A @endif</td> --}}
                    <td>{{ isset($rider->passport->personal_info->nat_phone) ? $rider->passport->personal_info->nat_phone : 'N/A' }}</td>
                </tr>
                @endif
                @endif
            @endforeach
            </tbody>
        </table>
</div>
    @else
    <h4 class="text-center">No data Found</h4>
@endif

<script>
    $(document).ready(function () {
        'use strict';

        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "40%"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Deliveroo Cod Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                'pageLength',
            ],
            "scrollY": false,
        });

    });
</script>
