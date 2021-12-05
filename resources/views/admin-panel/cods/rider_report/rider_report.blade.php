<div class="total" style="float: right;margin-top: -10px;"><h5><b> Total Riders: {{ isset($riders) ? ($riders->count()) : 0 }} </b></h5></div>
<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered text-11" id="rider_report" style="width:100%;">
        <thead>
        <tr>
            <th></th>
            <th scope="col">Name</th>
            <th scope="col">ZDS Code</th>
            <th scope="col">PPUID</th>
            <th scope="col">Passport No</th>
            <th scope="col" class="filtering_source_from">DC Name</th>
            <th scope="col" class="filtering_source_from">Platform</th>
            <th scope="col">Rider Id</th>
            <th scope="col">City</th>
            <th scope="col">Bike</th>
            <th scope="col">Bike Checkin</th>
            <th scope="col">SIM</th>
            <th scope="col">SIM Checkin</th>
            <th scope="col">Passport Status</th>
            <th scope="col">Visa Expiry</th>
            <th scope="col">Passport Expiry</th>
            <th scope="col">Cod Balance</th>
            <th scope="col">Completed Orders</th>
            <th scope="col">Worked Hours</th>
            <th scope="col">FollowUp</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($riders as $rider)
            <?php
            // deliveroo
            if($rider->plateformdetail->id == '4'){
                $total_pending_amount = 0;
                $total_paid_amount = 0;

                if(isset($rider->cod_upload)){
                    $total_pending_amount = $rider->cod_upload->total;
                }else {
                    $total_pending_amount = 0;
                }
                if(isset($rider->cods)){
                    $now_cod = $rider->cods->cod_total;
                }else {
                    $now_cod = 0;
                }
                if(isset($rider->codadjust)){
                    $adj_req_t = $rider->codadjust->adj_req_total;
                }else {
                    $adj_req_t = 0;
                }
                if(isset($rider->close_month)){
                    $close_m = $rider->close_month->close_total;
                }else {
                    $close_m = 0;
                }
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
            //talabat
            }elseif($rider->plateformdetail->id == '15' || $rider->plateformdetail->id == '34'){
                if(isset($rider->talabat_cod->current_day_balance)){
                    $remain_amount = $rider->talabat_cod->current_day_balance;
                }else {
                    $remain_amount = 0;
                }
            //carrefour
            }elseif($rider->plateformdetail->id == '38'){
                $total_pending_amount = 0;
                $total_paid_amount = 0;

                if(isset($rider->carrefour_upload)){
                    $total_pending_amount = $rider->carrefour_upload->total;
                }else {
                    $total_pending_amount = 0;
                }
                if(isset($rider->carrefour_cod)){
                    $now_cod = $rider->carrefour_cod->cod_total;
                }else {
                    $now_cod = 0;
                }
                if(isset($rider->carrefour_close)){
                    $close_m = $rider->carrefour_close->close_total;
                }else {
                    $close_m = 0;
                }
                if($now_cod != null){
                    $total_paid_amount = $now_cod;
                }
                if($close_m != null){
                    $total_paid_amount = $total_paid_amount+$close_m;
                }
                $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
            //careem
            }elseif($rider->plateformdetail->id == '1' || $rider->plateformdetail->id == '32'){
                $total_pending_amount = 0;
                $total_paid_amount = 0;

                if(isset($rider->careem_upload)){
                    $total_pending_amount = $rider->careem_upload->total;
                }else {
                    $total_pending_amount = 0;
                }
                if(isset($rider->careem_cod)){
                    $now_cod = $rider->careem_cod->cod_total;
                }else {
                    $now_cod = 0;
                }
                if(isset($rider->careem_close)){
                    $close_m = $rider->careem_close->close_total;
                }else {
                    $close_m = 0;
                }
                if($now_cod != null){
                    $total_paid_amount = $now_cod;
                }
                if($close_m != null){
                    $total_paid_amount = $total_paid_amount+$close_m;
                }
                $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
            }else{
                $remain_amount = 'N/A';
            }
            ?>
            <tr>
                <td></td>
                <td>{{ $rider->rider_passport->personal_info->full_name }}</td>
                <td>{{ $rider->rider_passport->zds_code->zds_code }}</td>
                <td>{{ $rider->rider_passport->pp_uid }}</td>
                <td>{{ $rider->rider_passport->passport_no }}</td>
                <td>{{ isset($rider->rider_passport->rider_dc_detail->user_detail->name) ? $rider->rider_passport->rider_dc_detail->user_detail->name : 'N/A' }}</td>
                <td>{{ $rider->plateformdetail->name }}</td>
                @if (!$rider->rider_passport->check_platform_code_exist->isEmpty())
                    <?php $p_code = $rider->rider_passport->check_platform_code_exist->where('platform_id',$rider->plateformdetail->id)->first(); ?>
                        <td>{{ isset($p_code) ? $p_code->platform_code  : 'N/A' }}</td>
                @else
                    <td>N/A</td>
                @endif
                <td>{{ isset($rider->city->name) ? $rider->city->name : 'N/A' }}</td>
                <td>{{ isset($rider->rider_passport->rider_bike_replacement->temporary_bike->plate_no) ? $rider->rider_passport->rider_bike_replacement->temporary_bike->plate_no : 'N/A' }}</td>
                <td>{{ isset($rider->rider_passport->rider_bike_replacement->replace_checkin) ? $rider->rider_passport->rider_bike_replacement->replace_checkin : 'N/A' }}</td>
                <td>{{ isset($rider->rider_passport->rider_sim_assign->telecome->account_number ) ? $rider->rider_passport->rider_sim_assign->telecome->account_number : 'N/A' }}</td>
                <td>{{ isset($rider->rider_passport->rider_sim_assign->checkin) ? $rider->rider_passport->rider_sim_assign->checkin : 'N/A' }}</td>
                <td>
                    @if($rider->rider_passport->passport_with_rider)
                        <span>With Rider</span>
                    @elseif($rider->rider_passport->passport_in_locker)
                        <span>In Locker</span>
                    @elseif($rider->rider_passport->passport_to_lock)
                        <span>With Controller</span>
                    @else
                        <span>N/A</span>
                    @endif
                </td>
                <td>
                    {{ $rider->passport->visa_pasted ? dateToRead($rider->passport->visa_pasted->expiry_date) : 'NA' }}
                </td>
                <td>
                    {{ $rider->passport->date_expiry ? dateToRead($rider->passport->date_expiry) : 'NA' }}
                </td>
                <td>{{ isset($remain_amount) ? $remain_amount : 'N/A' }}</td>
                @if(isset($rider->talabat_orders->completed_orders))
                    <td>{{ isset($rider->talabat_orders->completed_orders) ? $rider->talabat_orders->completed_orders : 'N/A' }}<br>({{ isset($rider->talabat_orders->start_date) ? date('d/m/Y', strtotime($rider->talabat_orders->start_date)) :'' }})</td>
                @else
                    <td>N/A</td>
                @endif
                @if(isset($rider->talabat_orders->total_working_hours))
                    <td @if($rider->talabat_orders->total_working_hours == '0') style="background-color: #ff6666;" @endif>{{ isset($rider->talabat_orders->total_working_hours) ? $rider->talabat_orders->total_working_hours : 'N/A' }}<br>({{ isset($rider->talabat_orders->start_date) ? date('d/m/Y', strtotime($rider->talabat_orders->start_date)) :'' }})</td>
                @else
                    <td>N/A</td>
                @endif
                <td>
                    <button type="button" class="btn btn-sm btn-block col btn-info follow_up" data-id="{{ $rider->passport_id }}">Add</button>
                    <button type="button" class="btn btn-sm btn-block col btn-info follow_up_list" data-id="{{ $rider->passport_id }}">View ( {{ count($rider->follow_ups) }} )</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $('.follow_up').on('click',function(){
        var passport_id = $(this).attr('data-id');
        $('#passport_id').val(passport_id);
        $("#followup_model").modal('show');
    });
    $('.follow_up_list').on('click',function(){
        var passport_id = $(this).attr('data-id');

        $.ajax({
            url: "{{ route('get_rider_followups') }}",
            method: 'Get',
            data: {passport_id:passport_id},
            success:function(response){
                $('#followUpCallListHolder').empty();
                $('#followUpCallListHolder').append(response.html);
                $("#followups").modal('show');
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        'use strict';
        $('#rider_report').DataTable( {
            initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_source_from').each(function(i, v){
                        filtering_columns.push(v.cellIndex+1)
                    });
                    $(".filter-list").remove();
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm filter-list'><option value="">All</option></select>`)
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
                            title: 'Rider Report',
                            text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
                'pageLength',
            ],
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });
    });
</script>
