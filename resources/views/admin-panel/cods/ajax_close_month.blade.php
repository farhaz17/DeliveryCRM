<div class="card text-left">
    <div class="card-body">
        @if(count($riderProfile)>0)
        <div class="table-responsive">
            <form action="{{ route('cod_save_close_month') }}" method="POST">
                @csrf
                <input type="hidden" value="" id="select_platform" name="select_platform" >
                <input type="hidden" value="" id="select_quantity" name="select_quantity" >
                <input type="hidden" value="" id="select_date_time" name="select_date_time" >
                <div class="row">
                    <div class="form-group col-4"></div>
                    <div class="form-group col-4">
                        <label for="start_date">Date</label>
                        <input name="start_date" id="start_date" class="form-control form-control-sm" type="date" value="{{ date('Y-m-d') }}" required/>
                    </div>
                </div>
                <table class="table table-sm table-striped table-bordered text-10" id="datatable">
                    <thead>
                    <tr>
                        <th></th>
                        <th scope="col">
                            <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                <input type="checkbox"   id="checkAll" checked><span>All</span><span class="checkmark"></span>
                            </label>
                        </th>
                        <th scope="col">Rider Name</th>
                        <th scope="col">Platform</th>
                        <th scope="col">Rider id</th>
                        <th scope="col">Remain COD</th>
                        <th scope="col">Amount</th>
                        {{-- <th scope="col">Close Amount</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($riderProfile as $key => $rider)
                        <?php
                        $total_pending_amount = 0;
                        $total_paid_amount = 0;
                        $total_pending_amount = $rider->total;

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
                        if($remain_amount>0){
                            $total_amt [] = $remain_amount;
                        }
                        ?>
                        @if ($remain_amount > '0')
                        <tr>
                            <td></td>
                            <td>
                                <label class="checkbox checkbox-outline-primary">
                                    <input type="checkbox" name="details[{{$key}}][rider_ids]" value="{{ isset($rider->rider_id) ? $rider->rider_id : '' }}"  checked="checked" class="checkbox_cls"><span></span><span class="checkmark"></span>
                                </label>
                            </td>
                            <td>{{ isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : 'N/A' }}</td>
                            <td>{{ isset($rider->rider_code->platform_name->name) ? $rider->rider_code->platform_name->name : 'N/A' }}</td>
                            @if (!$rider->passport->check_platform_code_exist->isEmpty())
                                <?php $p_code = $rider->passport->check_platform_code_exist->where('platform_id','4'); ?>
                                <td>
                                    @foreach($p_code as $p_codes)
                                        {{ isset($p_codes) ? $p_codes->platform_code : 'N/A' }}<br>
                                    @endforeach
                                </td>
                            @else
                                <td>N/A</td>
                            @endif
                            <td>{{ $remain_amount }}</td>
                            <td><input type="number" class="form-control form-control-sm" step="any" value="{{ $remain_amount }}" name="details[{{$key}}][amount]" ></td>
                            {{-- <td><input type="text" class="form-control form-control-sm"  readonly value="0" name="close_value[]"  ></td> --}}
                            <input type="hidden" value="{{$rider->passport_id}}" id="name" name="details[{{$key}}][passport_id]" >
                            {{-- <input type="hidden" value="{{ $rider->rider_id }}" id="platform" name="details[{{$key}}][platform]" > --}}
                            {{-- <input type="hidden" value="{{ $remain_amount }}" id="remain" name="details[{{$key}}][remain]" > --}}
                        </tr>
                        @endif
                    @endforeach
                    @if (isset($total_amt))
                        @php
                            $sum = array_sum($total_amt);
                        @endphp
                    @endif


                    <tr>
                        <td></td>
                        <td></td>
                        <td><span style="font-size: 15px;">Total Amount</span></td>
                        <td></td>
                        <td></td>
                        <td>@if (isset($sum))<span style="font-size: 15px;">{{ $sum }}</span>@endif</td>
                        {{-- <td></td> --}}
                        <td>
                            <button type="button" class="btn btn-primary" id="save_btn">save</button>
                            <button type="submit" class="btn btn-primary" id="form_submit_btn" style="display: none;">save</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
         @else
            <h4 class="text-center">No data Found</h4>
        @endif
    </div>
</div>

<script>
    $("#checkAll").click(function () {
        $('.checkbox_cls').not(this).prop('checked', this.checked);
    });
</script>
<script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 2000,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Cod Close Month',
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
