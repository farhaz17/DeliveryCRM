@if($traffic_for == 1)
    <label for="traffic_for_model_id">Company Name / License No.</label>
    <select class="form-control form-control-sm select2" name="traffic_for_model_id" id="traffic_for_model_id"> 
        <option value="" >Select Company</option>
        @forelse($data as $company)
            <option value="{{ $company->id }}" value="{{ $company->id }}">{{ $company->name }} | {{ $company->trade_license_no }}</option>
        @empty  
        <p>No name available!</p>
        @endforelse
    </select>
@elseif($traffic_for == 2)
    <label for="traffic_for_model_id">Passport No</label>
    <select class="form-control form-control-sm select2" name="traffic_for_model_id" id="traffic_for_model_id"> 
        <option value="" >Select Company</option>
        @forelse($data as $passport)
            <option value="{{ $passport->id }}">{{ $passport->sur_name  ?? ' ' }} {{ $passport->given_name  ?? '' }}</option>
        @empty  
        <p>No name available!</p>
        @endforelse
    </select>
@elseif($traffic_for == 3)
    <label for="traffic_for_model_id">Customer Or Supplier</label>
    <select class="form-control form-control-sm select2" name="traffic_for_model_id" id="traffic_for_model_id"> 
        <option value="" >Select Customer / Supplier</option>
        @forelse($data as $customer)
            <option value="{{ $customer->id }}">{{ $customer->contact_name  ?? ' ' }} </option>
        @empty  
        <p>No name available!</p>
        @endforelse
    </select>
@endif