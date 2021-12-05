@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'master-menu-items']) }}">Company Master</a></li>
      <li class="breadcrumb-item active" aria-current="page">License</li>
    </ol>
</nav>
<form action="{{ route('company_license_info_update', $license->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="card col-lg-8 offset-lg-2 mb-2">
        <div class="card-body">
            <div class="card-title mb-3">License Details</div>
                <div class="row">
                    {{-- @dd($license->license_for == 'company' ? 'checked' : '') --}}
                    <div class="col-md-3 form-group mb-1">
                        <label class="radio radio-outline-primary">
                            <input type="radio"  class="license_for_btn"  name="license_for" {{ $license->license_for == 'company' ? 'checked' : '' }}     value="company"><span>Company</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-3 form-group mb-1">
                        <label class="radio radio-outline-primary">
                            <input type="radio" class="license_for_btn" name="license_for" {{ $license->license_for == 'rental' ? 'checked' : '' }}  value="rental"><span>Rental</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-3 form-group mb-1">
                        <label class="radio radio-outline-primary">
                            <input type="radio" class="license_for_btn"  name="license_for" {{ $license->license_for == '4pl' ? 'checked' : '' }}  value="4pl"><span>4PL</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="col-md-3 form-group mb-1">
                        <label class="radio radio-outline-primary">
                            <input type="radio"  class="license_for_btn" name="license_for" {{ $license->license_for == 'vendor' ? 'checked' : '' }}  value="vendor"><span>Vendor</span><span class="checkmark"></span>
                        </label>
                    </div>
                    <hr>
                    
                    <div class="col-md-4 form-group mb-1">
                        <label for="state_id">State</label>
                        <select class="form-control form-control-sm" name="state_id" id="state_id" required>
                            <option value="">Select State</option>
                            @forelse ($states as $state)
                                <option {{ $state->id == $license->state_id ? "selected" : "" }} value="{{ $state->id }}">{{ $state->name }}</option>
                            @empty
                                <p>No State found!</p>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="license_type">License Type</label>
                        <select class="form-control form-control-sm" name="license_type" id="license_type">
                            <option value="">Select Type</option>
                            <option {{ $license->license_type == "llc" ? "selected" : "" }} value="llc">LLC</option>
                            <option {{ $license->license_type == "civil_agent" ? "selected" : ""}} value="civil_agent">Civil Agent</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="license_category">Category</label>
                        <select class="form-control form-control-sm" name="license_category" id="license_category">
                            <option value="" >Select Category</option>
                            <option {{ $license->license_category == "0" ? "selected" : "" }} value="0">Professional</option>
                            <option {{ $license->license_category == "1" ? "selected" : "" }}  value="1" >Commercial</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="license_name">Trade name</label>
                        <input class="form-control form-control-sm" id="license_name" value="{{ $license->name ?? '' }}" type="text" placeholder="" name="name">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="trade_license_no">License No.</label>
                        <input class="form-control form-control-sm" id="" type="text" placeholder="" value="{{$license->trade_license_no ?? ''}}" name="trade_license_no" id="trade_license_no">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="issue_date">Issue Date</label>
                        <input class="form-control form-control-sm" type="date" id="issue_date" value="{{ $license->issue_date ?? '' }}" placeholder="" name="issue_date">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="expiry_date">Expiry Date</label>
                        <input class="form-control form-control-sm" type="date" id="expiry_date" value="{{ $license->expiry_date ?? '' }}" placeholder="" name="expiry_date">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="uuns">D&B U-U-N-S R</label>
                        <input class="form-control form-control-sm" id="uuns" value="{{ $license->uuns ?? "" }}" placeholder="" name="uuns">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="registration_no">Registration No.</label>
                        <input class="form-control form-control-sm" id="registration_no" value="{{ $license->registration_no ?? '' }}" type="text" placeholder="" name="registration_no">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="dcci">DCCI No.</label>
                        <input class="form-control form-control-sm" id="dcci" value="{{ $license->dcci ?? '' }}" type="text" placeholder="" name="dcci">
                    </div>
                    <div class="col-md-4 form-group mb-1">
                        <label for="tax">Tax</label>
                        <input class="form-control form-control-sm" id="tax" value="{{ $license->tax ?? '' }}" type="text" placeholder="" name="tax">
                    </div>
                    <div class="col-md-4 form-group mb-1" style="display: {{ $license->license_for == 'rental' ? 'block' : 'none' }}" id="rental_type_block">
                        <label for="rent_for">Rental Type</label>
                        <select class="form-control form-control-sm" name="rent_for" id="rent_for">
                            <option value="">Select Type</option>
                            <option {{ $license->rent_for == '0' ? 'selected' : '' }} value="0">Rental</option>
                            <option {{ $license->rent_for == '1' ? 'selected' : '' }} value="1">Lease To Own</option>
                        </select>
                    </div>
                </div>
            </div>
    </div>

    <div class="card col-lg-8 offset-lg-2 mb-2">
        <div class="card-title mb-3 col-12">License Members </div>
        <div class="card-body">
                <div id="add-more-member-holder">
                    @php $members = json_decode($license->member_ids) @endphp
                    @if($members != null)
                    @forelse($members as $key => $member)
                    <div class="row" id="row{{$key}}">
                        <div class="col-md-3 form-group mb-1">
                            <label for="state_id">Select Member</label>
                            <select class="form-control form-control-sm" name="member_ids[]" id="member_ids">
                                <option value="">Select Member</option>
                                @forelse ($passport_members as $member)
                                    <option {{ $member->id == json_decode($license->member_ids)[$key] ? 'selected' : '' }} value="{{$member->id}}">{{ $member->sur_name ?? "Na" }}</option>
                                @empty
                                    <p>No Member found!</p>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-2 form-group mb-1">
                            <label for="">No.</label>
                            <input class="form-control form-control-sm" id="" type="number" value="{{ json_decode($license->member_no)[$key] ?? '' }}" placeholder="" name="member_no[]">
                        </div>
                        <div class="col-md-2 form-group mb-1">
                            <label for="">Share</label>
                            <input class="form-control form-control-sm" id="" type="text" value="{{ json_decode($license->member_share)[$key] ?? '' }}" placeholder="" name="member_share[]">
                        </div>
                        <div class="col-md-3 form-group mb-1">

                            
                            <label for="">Role</label>
                            <select class="form-control form-control-sm" name="member_role[]">
                                <option value="">Select Role</option>
                                <option {{ json_decode( $license->member_role)[$key] == 'partner' ? 'selected' : '' }} value="partner">Partner</option>
                                <option {{ json_decode( $license->member_role)[$key] == 'agent' ? 'selected' : '' }} value="agent">Agent</option>
                                <option {{ json_decode( $license->member_role)[$key] == 'manager' ? 'selected' : '' }} value="manager">Manager</option>
                            </select>
                        </div>
                        @if($key == 0)
                            <div class="col-md-1 form-group mb-1">
                                <label for="">&nbsp;</label>
                                <button class="btn btn-primary btn-sm" type="button" id="add-more-member">Add more Member</button>
                            </div>
                        @else
                        <div class="col-md-1 form-group mb-1">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-danger btn-sm delete_btn" type="button" data-row_id = "{{'row'.$key}}">Delete member</button>
                        </div>
                        @endif
                    </div>
                    @empty
                     
                    @endforelse

                    @else
                    <div class="row">
                        <div class="col-md-3 form-group mb-1">
                            <label for="state_id">Select Member</label>
                            <select class="form-control form-control-sm" name="member_ids[]" id="member_ids">
                                <option value="">Select Member</option>
                                @forelse ($passport_members as $member)
                                    <option value="{{$member->id}}">{{ $member->sur_name ?? "Na" }}</option>
                                @empty
                                    <p>No Member found!</p>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-2 form-group mb-1">
                            <label for="">No.</label>
                            <input class="form-control form-control-sm" id="" type="number" placeholder="" name="member_no[]">
                        </div>
                        <div class="col-md-2 form-group mb-1">
                            <label for="">Share</label>
                            <input class="form-control form-control-sm" id="" type="text" placeholder="" name="member_share[]">
                        </div>
                        <div class="col-md-3 form-group mb-1">
                            <label for="">Role</label>
                            <select class="form-control form-control-sm" name="member_role[]">
                                <option value="">Select Role</option>
                                <option value="partner">Partner</option>
                                <option value="agent">Agent</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="col-md-1 form-group mb-1">
                            <label for="">&nbsp;</label>
                            <button class="btn btn-primary btn-sm" type="button" id="add-more-member">Add more</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
    </div>
    <div class="card col-lg-8 offset-lg-2 mb-2">
        <div class="card-title mb-3 col-12">License Partners </div>
        <div class="card-body">
            <div id="add-more-partner-holder">
            @php $partners = json_decode($license->partner_ids) @endphp
            @if($partners != null)
                @forelse($partners as $key => $partner)
                <div class="row" id="partner{{$key}}">
                    <div class="col-md-3 form-group mb-1">
                        <label for="">Select Partner</label>
                        <select class="form-control form-control-sm" name="partner_ids[]" id="partner_ids">
                            <option value="">Select Partner</option>
                            @forelse ($passport_partners as $partner)
                                <option {{ $partner->id == json_decode($license->partner_ids)[$key] ? 'selected' : '' }} value="{{$partner->id}}">{{ $partner->sur_name ?? "Na" }}</option>
                            @empty
                                <p>No Partner found!</p>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Sl. No.</label>
                        <input class="form-control form-control-sm" value="{{ json_decode($license->partner_no)[$key] ?? '' }}" id="" type="number" placeholder="" name="partner_no[]">
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Share</label>
                        <input class="form-control form-control-sm" value="{{ json_decode($license->partner_share)[$key] ?? '' }}" id="" type="text" placeholder="" name="partner_share[]">
                    </div>
                    @if($key == 0)
                    <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary btn-sm" id="add-more-partner" type="button">Add more Partner</button>
                    </div>
                    @else
                    <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-danger btn-sm delete_btn" type="button" data-partner_row_id="partner{{$key}}" >Delete partner</button>
                    </div>
                    @endif
                </div>
                @empty

                @endforelse
                @else
                <div class="row">
                    <div class="col-md-3 form-group mb-1">
                        <label for="state_id">Select Partner</label>
                        <select class="form-control form-control-sm" name="partner_ids[]" id="partner_ids">
                            <option value="">Select Partner</option>
                            @forelse ($passport_partners as $partner)
                                <option value="{{$partner->id}}">{{ $partner->sur_name ?? "Na" }}</option>
                            @empty
                                <p>No Partner found!</p>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Sl. No.</label>
                        <input class="form-control form-control-sm" id="" type="number" placeholder="" name="partner_no[]">
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Share</label>
                        <input class="form-control form-control-sm" id="" type="text" placeholder="" name="partner_share[]">
                    </div>
                    <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary btn-sm" id="add-more-partner" type="button">Add more Partner</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card col-lg-8 offset-lg-2 mb-2">
        <div class="card-title mb-3 col-12">License Activities</div>
        <div class="card-body" id="activity-list-holder">
            @php $activities = json_decode($license->license_activity ) @endphp
            @if($activities != null)
                @forelse($activities as $key => $activity)
                <div class="row" id="activity_row{{$key}}">
                    <div class="col-md-10 form-group mb-1">
                        <input class="form-control form-control-sm" id="activity_input" value="{{ json_decode($license->license_activity)[$key] ?? ''}}" type="text" placeholder="Enter activity" name="license_activity[]">
                    </div>
                    @if($key == 0)
                    <div class="col-md-2 form-group mb-1">
                        <button class="btn btn-primary btn-block btn-sm" id="add_to_list" type="button">Add more Activity</button>
                    </div>
                    @else
                    <div class="col-md-2 form-group mb-1">
                        <button class="btn btn-danger btn-sm delete_activity" id="" type="button" data-activity_row_id = "activity_row{{$key}}">Delete Activity</button>
                    </div>
                    @endif
                </div>
                @empty

                @endforelse
            @else
            <div class="row" id="">
                <div class="col-md-10 form-group mb-1">
                    <input class="form-control form-control-sm" id="activity_input" type="text" placeholder="Enter activity" name="license_activity[]">
                </div>
                <div class="col-md-2 form-group mb-1">
                    <button class="btn btn-primary btn-block btn-sm" id="add_to_list" type="button">Add more Activity</button>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="card col-lg-8 offset-lg-2 mb-2">
        <div class="card-body">
            <div id="add-more-partner-holder">
                <div class="row">
                    {{-- @dd($license->license_attachment) --}}
                    <div class="col-md-4 form-group mb-1">
                        <label for="license_attachment">License Attachment</label>
                        <input class="form-control-file form-control-sm" id="license_attachment" type="file" placeholder="" name="license_attachment"><br>
                        @if($license->license_attachment)
                        <a  href="{{ $license->license_attachment ? asset($license->license_attachment) : asset('assets/images/faces/3.jpg')}}" 
                            target="_blank">View Existing</a> | 
                        <a  href="{{ $license->license_attachment ?  asset($license->license_attachment) : asset('assets/images/faces/3.jpg')}}" 
                            download="{{ asset($license->license_attachment) }}">Download</a>
                        @endif
                    </div>
                    <div class="col-md-4 form-group mb-1" id="tax_upload_block">
                        <label for="tax_attachment">Tax Attachment</label>
                        <input class="form-control-file form-control-sm" id="tax_attachment" type="file" placeholder="" name="tax_attachment"><br>
                        @if($license->tax_attachment)
                        <a  href="{{ $license->tax_attachment ? asset($license->tax_attachment) : asset('assets/images/faces/3.jpg')}}" 
                            target="_blank">View Existing</a> | 
                        <a  href="{{ $license->tax_attachment ?  asset($license->tax_attachment) : asset('assets/images/faces/3.jpg')}}" 
                            download="{{ asset($license->tax_attachment) }}">Download</a>
                        @endif
                    </div>
                    <div class="col-md-4 form-group mb-1" id="contract_upload_block">
                        <label for="contract_attachment">Contract attachment</label>
                        <input class="form-control-file form-control-sm" id="contract_attachment" type="file" placeholder="" name="contract_attachment"><br>
                        @if($license->contract_attachment)
                        <a  href="{{ $license->contract_attachment ? asset($license->contract_attachment) : asset('assets/images/faces/3.jpg')}}" 
                            target="_blank">View Existing</a> | 
                        <a  href="{{ $license->contract_attachment ?  asset($license->contract_attachment) : asset('assets/images/faces/3.jpg')}}" 
                            download="{{ asset($license->contract_attachment) }}">Download</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $(".select2").select2();
    var member_row_number = {{ $members!= null ? count($members) : 0 }};
    $('#add-more-member').click(function(){
        var new_member_row = `                <div class="row" id="row`+member_row_number+`">
                    <div class="col-md-3 form-group mb-1">
                        <label for="state_id">Select Member</label>
                        <select class="form-control form-control-sm" name="member_ids[]" id="member_ids">
                            <option value="">Select Member</option>
                            @forelse ($passport_members as $member)
                                <option value="{{$member->id}}">{{ $member->sur_name ?? "Na" }}</option>
                            @empty
                                <p>No Member found!</p>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">No.</label>
                        <input class="form-control form-control-sm" id="" type="number" placeholder="" name="member_no[]">
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Share</label>
                        <input class="form-control form-control-sm" id="" type="text" placeholder="" name="member_share[]">
                    </div>
                    <div class="col-md-3 form-group mb-1">
                        <label for="">Role</label>
                        <select class="form-control form-control-sm" name="member_role[]">
                            <option value="">Select Role</option>
                            <option value="partner">Partner</option>
                            <option value="agent">Agent</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-danger btn-sm delete_btn" data-row_id = "row`+member_row_number+`">Delete member</button>
                    </div>
                </div>`;
        $('#add-more-member-holder').append(new_member_row);
        member_row_number++
    });
    $(document).ready(function(){
        $('#add-more-member-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');
            $("#"+ids).remove();
        });
    });
    var activity_row_number = {{ $activities != null ? count($activities) : 0}};
    $('#add_to_list').click(function(){
        var new_activity_row = `        <div class="row" id="activity_row`+activity_row_number+`">
            <div class="col-md-10 form-group mb-1">
                <input class="form-control form-control-sm" name="license_activity[]" id="activity_input" type="text" placeholder="Enter activity">
            </div>
            <div class="col-md-2 form-group mb-1">
                <button class="btn btn-danger btn-sm delete_activity" id="" data-activity_row_id = "activity_row`+activity_row_number+`">Delete Activity</button>
            </div>
        </div>`;
        $('#activity-list-holder').append(new_activity_row);
        activity_row_number++
    });
    $(document).ready(function(){
        $('#activity-list-holder').on('click', '.delete_activity', function() {
            var ids = $(this).attr('data-activity_row_id');
            $("#"+ids).remove();
        });
    });
    var partner_row_number = {{ $partners != null ? count($partners) : 0 }};
    $('#add-more-partner').click(function(){
        var new_partner_row = `<div class="row" id="partner`+partner_row_number+`">
                    <div class="col-md-3 form-group mb-1">
                        <label for="state_id">Select Partner</label>
                        <select class="form-control form-control-sm" name="partner_ids[]" id="partner_ids">
                            <option value="">Select Partner</option>
                            @forelse ($passport_partners as $partner)
                                <option value="{{$partner->id}}">{{ $partner->sur_name ?? "Na" }}</option>
                            @empty
                                <p>No Partner found!</p>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Sr. No.</label>
                        <input class="form-control form-control-sm" id="" type="number" placeholder="" name="partner_no[]">
                    </div>
                    <div class="col-md-2 form-group mb-1">
                        <label for="">Share</label>
                        <input class="form-control form-control-sm" id="" type="text" placeholder="" name="partner_share[]">
                    </div>
                    <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-danger btn-sm delete_btn" type="button" data-partner_row_id="partner`+partner_row_number+`" >Delete partner</button>
                    </div>
                </div>`;
                $('#add-more-partner-holder').append(new_partner_row);
                partner_row_number++
    });
    $(document).ready(function(){
        $('#add-more-partner-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-partner_row_id');
            $("#"+ids).remove();
        });
    });

    $('.license_for_btn').change(function(){
        console.log($(this).val())
        var license_for = $(this).val();
        switch(license_for){
            case "company" :
                $('#rental_type_block').hide();
            break;
            case "rental" :
                $('#contract_upload_block').show();
                $('#rental_type_block').show();

            break;
            case "4pl" :
                $('#rental_type_block').hide();
            break;
            case "vendor" :
                $('#rental_type_block').hide();
            default :
            "Company"
        }
    });

    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
            break;
    }
    @endif
</script>
@endsection