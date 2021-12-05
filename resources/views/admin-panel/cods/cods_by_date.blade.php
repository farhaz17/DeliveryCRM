<div class="row">
    <div class="col-md-2 mb-3"></div>
    <div class="col-md-8 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <button class="btn btn-danger ml-2 delete_cls" type="submit" >Delete All</button>
                <div class="totals" style="float: right;"><h5><b> Total Amount: {{ $cods->sum('amount') }} <span class="badge badge-success">AED</span></b></h5></div><br><br>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-bordered text-11" id="cods" style="width:100%;">
                        <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Name</th>
                            <th scope="col">Rider Id</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Date</th>
                            <th scope="col">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($cods as $cod)
                            <tr>
                                <td></td>
                                <td>{{ isset($cod->passport->personal_info->full_name) ? $cod->passport->personal_info->full_name : '' }}</td>
                                @if (!$cod->passport->check_platform_code_exist->isEmpty())
                                <?php $p_code = $cod->passport->check_platform_code_exist->where('platform_id','4'); ?>
                                <td>
                                    @foreach($p_code as $p_codes)
                                        {{ isset($p_codes) ? $p_codes->platform_code : 'N/A' }}<br>
                                    @endforeach
                                </td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td>{{ $cod->created_at->format('Y-m-d') }}</td>
                                @if (isset($cod->order_date) )
                                    <td>{{ $cod->order_date }}</td>
                                @elseif (isset($cod->type))
                                    <td>{{ $cod->date }}</td>
                                @else
                                    <td></td>
                                @endif
                                <td>{{ $cod->amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.delete_cls').click(function(){
        $('#delete_modal').modal('show');
    });
</script>
<script>
    $(document).ready(function () {
        'use strict';
        $('#cods').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollX": true,
        });
    });
</script>
