<table>
    @if (count($amounts)=='0')
    <p style="color: red"> <strong>  No Record Found</strong></p>

    @else
    @foreach ($amounts as $item)
    <tr style="margin-top:10px: ">
        <td><strong> Step Name </strong></td><td>&nbsp &nbsp &nbsp &nbsp</td><td class="ml-3">{{isset($item->master_renew->step_name)?$item->master_renew->step_name:""}}</td>
    </tr>
    <tr>
        <td><strong>Amount</strong></td><td>&nbsp &nbsp &nbsp &nbsp</td><td class="ml-3">{{isset($item->amount)?$item->amount:""}}</td>
    </tr>
    <tr>
        <td><strong>Status</strong></td>
        <td>&nbsp &nbsp &nbsp &nbsp</td>
        <td class="ml-3">
            @if(isset($item->pay_status) && $item->pay_status ==1 )
            <span class="badge badge-success">Paid</span>

            @else

            <span class="badge badge-danger">Unpaid</span>
        @endif
    </td>
    </tr>
    <tr>
        <td>&nbsp &nbsp &nbsp &nbsp</td>
    </tr>
    @endforeach
    @endif








</table>

