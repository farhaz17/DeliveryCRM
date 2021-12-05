@if ($record == 'no records')
<div id="statement-holder">
    <div class="row">
        <div class="col-12">
            <div class="responsive">
                <table class="table table-sm text-11 table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><b>Date</b></th>
                            <th scope="col"><b>Type</b></th>
                            <th scope="col"><b>Debit</b></th>
                            <th scope="col"><b>Credit</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center bolder">No Cod Record Found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div id="statement-holder">
    <div class="row">
        <div class="col-12">
            <h4 class="text-center mt-3 font-weight-bold">{{ $plate->full_name }}</h4><br>
            <div class="responsive">
                <table class="table table-sm text-11 table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><b>Date</b></th>
                            <th scope="col"><b>Type</b></th>
                            <th scope="col"><b>Debit</b></th>
                            <th scope="col"><b>Credit</b></th>
                        </tr>
                    </thead>
                    <tbody>
                @foreach($upload as $uploads)
                        <tr>
                            <td>{{ $uploads->start_date }}</td>
                            <td>Cod Upload</td>
                            <td>&nbsp;</td>
                            <td>{{ $uploads->amount }}</td>
                        </tr>
                @endforeach
                @foreach($codss as $cod)
                        <tr>
                            <td>{{ $cod->date }}</td>
                            {{-- @if($cod['type']=="1") --}}
                            <td>Cash</td>
                            {{-- @else
                            <td>Bank</td>
                            @endif --}}
                            <td>{{ $cod->amount }}</td>
                            <td></td>
                        </tr>
                @endforeach
                @foreach($closemonth as $closemonths)
                        <tr>
                            <td>{{ $closemonths->created_at->format('d-m-Y') }}</td>
                            <td>Close Month</td>
                            <td>{{ $closemonths->close_month_amount }}</td>
                            <td></td>
                        </tr>
                @endforeach
                <tr>
                    <td class="text-right"></td>
                    <td class="text-right"></td>
                    <td class="text-right"><b><span style="font-size: 15px">Balance</span></b></td>
                    <td class="text-left"><b><span style="font-size: 15px">{{ number_format($remain_amount,2) }}</span></b></td>
                </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
