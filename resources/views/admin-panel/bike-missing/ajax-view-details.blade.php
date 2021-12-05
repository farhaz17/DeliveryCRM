@if($process == 2)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Complaint Date</th>
            <th scope="col">Police Station</th>
            <th scope="col">Remarks</th>
            <th scope="col">Attachment</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$bike->complaint_date}}</td>
            <td>{{$bike->police_station}}</td>
            <td>{{$bike->remarks}}</td>
            <td>
                @if($bike->police_request_attachment)
                    @foreach (json_decode($bike->police_request_attachment) as $docs)
                    <a href="{{Storage::temporaryUrl($docs , now()->addMinutes(60)) }}" target="_blank">View File,</a>
                    @endforeach
                @endif
            </td>
        </tr>
    </tbody>
</table>
@elseif($process == 3)
    @if($bike->found_status == 1)
    <table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
        <thead class="table-dark">
            <tr>
                <th scope="col">Police Report</th>
                <th scope="col">Attachment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$bike->found_remarks}}</td>
                <td>
                    @if($bike->found_attachment)
                        @foreach (json_decode($bike->found_attachment) as $docs)
                        <a href="{{Storage::temporaryUrl($docs , now()->addMinutes(60)) }}" target="_blank">View File,</a>
                        @endforeach
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @else
    <table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
        <thead class="table-dark">
            <tr>
                <th scope="col">Police Report</th>
                <th scope="col">Attachment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$bike->police_report}}</td>
                <td>
                    @if($bike->police_report_attachment)
                        @foreach (json_decode($bike->police_report_attachment) as $docs)
                        <a href="{{Storage::temporaryUrl($docs , now()->addMinutes(60)) }}" target="_blank">View File,</a>
                        @endforeach
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
    @endif

@elseif($process == 4)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Remarks</th>
            <th scope="col">Document</th>
            <th scope="col">Offer Letter</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$bike->claim_remarks}}</td>
            <td>
                @if($bike->claim_documents)
                    @foreach (json_decode($bike->claim_documents) as $docs)
                    <a href="{{Storage::temporaryUrl($docs , now()->addMinutes(60)) }}" target="_blank">View File,</a>
                    @endforeach
                @endif
            </td>
            <td>
                @if($bike->claim_offer)
                    @foreach (json_decode($bike->claim_offer) as $offer)
                    <a href="{{Storage::temporaryUrl($offer , now()->addMinutes(60)) }}" target="_blank">View File,</a>
                    @endforeach
                @endif
            </td>
        </tr>
    </tbody>
</table>
@elseif($process == 5)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Amount</th>
            <th scope="col">Attachment</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$bike->payment_amount}}</td>
            <td>
                @if($bike->payment_attachment)
                    @foreach (json_decode($bike->payment_attachment) as $doc)
                    <a href="{{Storage::temporaryUrl($doc , now()->addMinutes(60)) }}" target="_blank">View File,</a>
                    @endforeach
                @endif
            </td>
        </tr>
    </tbody>
</table>
@elseif($process == 6)
<table class="table table-sm table-hover text-14 datatable-contract" style="width:100%;">
    <thead class="table-dark">
        <tr>
            <th scope="col">Remarks</th>
            <th scope="col">Date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$bike->cancellation_remarks}}</td>
            <td>
                {{$bike->cancellation_date}}
            </td>
        </tr>
    </tbody>
</table>
@endif
