<table >
    <thead>
    <tr>
        <th>PP UID</th>
        <th>passport No</th>
        <th>ZDS Code</th>
        <th>Labour Card No</th>
        <th>Person Code</th>
        <th>Payment Method</th>
        <th>Payment Location</th>
        <th>C3 card No</th>
        <th>C3 Code No</th>
        <th>C3 Expiry</th>
        <th>C3 card No 2</th>
        <th>C3 Code No 2</th>
        <th>C3 Expiry 2</th>
        <th>Lulu card No</th>
        <th>Lulu Code No</th>
        <th>Lulu Expiry</th>
        <th>Lulu card No 2</th>
        <th>Lulu Code No 2</th>
        <th>Lulu Expiry 2</th>
        <th>IBAN No</th>
        <th>Bank Name</th>
        <th>IBAN No 2</th>
        <th>Bank Name 2</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{$item->pp_uid}}</td>
            <td>{{$item->passport_no}}</td>
            <td>{{$item->zds_code}}</td>
            <td>{{$item->labour_card_no}}</td>
            <td>'{{$item->person_code}}'</td>
            <td>
                @if($item->cash_or_exchange == 1)
                    Office Cash
                @elseif($item->cash_or_exchange == 2)
                    Exchange Cash (Lulu)
                @elseif($item->cash_or_exchange == 3 || $item->cash_or_exchange == 4 || $item->cash_or_exchange == 5)
                    Card/Bank
                @endif
             </td>
            <td>{{$item->exchange_location}}</td>
            {{-- C3 Card Details --}}
            <td>
                @if(isset($item->c_three_details[0]))
                    {{ $item->c_three_details[0]->card_no }}
                    @if( isset($item->wps_payment->card_no) == $item->c_three_details[0]->card_no)
                    (Active)
                    @endif
                @endif
            </td>
            <td>
                {{ isset($item->c_three_details[0]) ? $item->c_three_details[0]->code_no : '' }}
            </td>
            <td>
                {{ isset($item->c_three_details[0]) ? date('d-m-Y', strtotime($item->c_three_details[0]->expiry )): '' }}
            </td>
            <td>
                @if(isset($item->c_three_details[1]))
                    {{ $item->c_three_details[1]->card_no }}
                    @if( isset($item->wps_payment->card_no) == $item->c_three_details[1]->card_no)
                    (Active)
                    @endif
                @endif
            </td>
            <td>
                {{ isset($item->c_three_details[1]) ? $item->c_three_details[1]->code_no : '' }}
            </td>
            <td>
                {{ isset($item->c_three_details[1]) ? date('d-m-Y', strtotime($item->c_three_details[1]->expiry )): '' }}
            </td>
            {{-- Lulu Card Details --}}
            <td>
                @if(isset($item->lulu_card_details[0]))
                    {{ $item->lulu_card_details[0]->card_no }}
                    @if( isset($item->wps_payment->card_no) == $item->lulu_card_details[0]->card_no)
                    (Active)
                    @endif
                @endif
            </td>
            <td>
                {{ isset($item->lulu_card_details[0]) ? $item->lulu_card_details[0]->code_no : '' }}
            </td>
            <td>
                {{ isset($item->lulu_card_details[0]) ? date('d-m-Y', strtotime($item->lulu_card_details[0]->expiry )): '' }}
            </td>
            <td>
                @if(isset($item->lulu_card_details[1]))
                    {{ $item->lulu_card_details[1]->card_no }}
                    @if( isset($item->wps_payment->card_no) == $item->lulu_card_details[1]->card_no)
                    (Active)
                    @endif
                @endif
            </td>
            <td>
                {{ isset($item->lulu_card_details[1]) ? $item->lulu_card_details[1]->code_no : '' }}
            </td>
            <td>
                {{ isset($item->lulu_card_details[1]) ? date('d-m-Y', strtotime($item->lulu_card_details[1]->expiry )): '' }}
            </td>
            <td>
                @if(isset($item->bank_details[0]))
                    {{ $item->bank_details[0]->iban_no }}
                    @if( isset($item->wps_payment->iban_no) == $item->bank_details[0]->iban_no)
                    (Active)
                    @endif
                @endif
            </td>
            <td>
                {{ isset($item->bank_details[0]) ? $item->bank_details[0]->bank_name : '' }}
            </td>
            <td>
                @if(isset($item->bank_details[1]))
                    {{ $item->bank_details[1]->iban_no }}
                    @if( isset($item->wps_payment->iban_no) == $item->bank_details[1]->iban_no)
                    (Active)
                    @endif
                @endif
            </td>
            <td>
                {{ isset($item->bank_details[1]) ? $item->bank_details[1]->bank_name : '' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
