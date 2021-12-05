@if( $request->network == 'Etisalat' )
    <label class="col-form-label" for="message-text-1">Etisalat Party No: (Company Name)</label>
    {{-- <input class="form-control form-control-sm" id="party_id" name="party_id" value="{{isset($telecome_edit)?$telecome_edit->party_id:""}}"  type="text"  required placeholder="Enter Party ID"  /> --}}
    <select name="party_id" id="party_id" class="form-control form-control-sm" required>
        <option value="" disabled  selected>Select One</option>
        @forelse ($accounts as $account)
            <option value="{{ $account->etisalat_party_id }}">{{ $account->etisalat_party_id }} ( {{ $account->company_name ?? '' }} )</option>
        @empty

        @endforelse
    </select>
@elseif( $request->network == 'DU' )
    <label class="col-form-label" for="message-text-1">Du Account No: (Company Name)</label>
    {{-- <input class="form-control form-control-sm" id="party_id" name="party_id" value="{{isset($telecome_edit)?$telecome_edit->party_id:""}}"  type="text"  required placeholder="Enter Party ID"  /> --}}
    <select name="party_id" id="party_id" class="form-control form-control-sm" required>
        <option value="" disabled selected>Select One</option>
        @forelse ($accounts as $account)
            <option value="{{ $account->du_acc }}">{{ $account->du_acc }} ( {{ $account->company_name ?? '' }} )</option>
        @empty
            
        @endforelse
    </select>
@endif