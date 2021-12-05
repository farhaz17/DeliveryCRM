<table class="display table table-striped table-bordered" id="datatable2">
    <thead class="thead-dark">
    <tr>
        <th>Referral Date</th>
        <th >Referred By</th>
        <th >Reference ZDS Code</th>
        <th>Name</th>
        <th>Passport Number</th>
        <th>Driving Linces Number</th>
        <th>Driving Copy</th>
        <th>Status</th>
{{--        <th>Credit Amount</th>--}}
{{--        <th>Credit Status</th>--}}
    </tr>
    </thead>
    <tbody>

    @foreach($referal as $row)
        <tr>
{{--            format('Y-m-d')--}}
            <td>{{isset($row->created_at)?$row->created_at:"N/A"}}</td>
            <td>{{isset($row->refer_by_user->personal_info->full_name)?$row->refer_by_user->personal_info->full_name:"N/A"}}</td>
            <td>{{isset($row->refer_by_user->zds_code->zds_code)?$row->refer_by_user->zds_code->zds_code:"N/A"}}</td>
            <td>{{$row->name}}</td>
            <td>{{$row->passport_no}}</td>
            <td>{{$row->driving_license}}</td>
            <td>

                <a class="attachment_display" href="{{ isset($row->driving_attachment) ? url($row->driving_attachment) : ''  }}"  target="_blank">
                    <strong style="color: blue">View</strong></a>

            <td>
                @if($row->status=='0')
                    Pending
                @elseif($row->status=='1')
                    Interview
                @elseif($row->status=='2')
                    Detail Collected
                @elseif($row->status=='3')
                    Hired
                @else
                @endif
            </td>
{{--            <td>--}}
{{--                {{isset($row->credit_amount)?$row->credit_amount:"N/A"}}--}}
{{--            </td>--}}
{{--            <td>--}}
{{--                @if($row->credit_status=='0')--}}
{{--                    <span style="color: darkred">Paid</span>--}}
{{--                @elseif($row->credit_status=='1')--}}
{{--                    <span style="color: green"> Unpaid</span>--}}
{{--                @else--}}
{{--                @endif--}}
{{--            </td>--}}


        </tr>
    @endforeach
    </tbody>
</table>
<span><strong>Total Amount Paid =</strong>{{$referal->where('credit_status','1')->sum('credit_amount')}} </span><br>
<span><strong>Total Amount Payble =</strong>{{$referal->where('credit_status','0')->sum('credit_amount')}} </span>
