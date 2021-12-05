<style>
    .form-group label {
        font-size: 10px;
        color: #70657b;
        margin-bottom: 0px;
        font-weight: bold;
    }
    .card-body {
        margin-top: -16px;
        margin-bottom: -44px;
        margin-top: -4px;
    }
    .modal-body {
        position: relative;
        flex: 1 1 auto;
        padding: 1rem;
        margin-top: -10px;
    }
    .form-control {
        border: initial;
        outline: initial !important;
        background: #f8f9fa;
        border: 1px solid #ced4da;
        color: #47404f;
        height: 25px;
        font-size: 12px;
    }
    select#attachment_name1 {

        padding-top: 1px;
    }


</style>

<form action="{{action('Passport\PassportController@update', $id)}}" enctype="multipart/form-data"  method="post">

    {!! csrf_field() !!}
    @if(isset($edit_passport))

        {{ method_field('PUT') }}

    @endif


    <div class="row">
        {{--                                <input class="form-control form-control" id="country_code" name="nation_id" value="{{$nation->id}}"  type="hidden" placeholder="Enter Country name" required />--}}
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Country Code</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->country_code:""}}" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code"  />
        </div>

        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Passport Number</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->passport_no:""}}" id="passport_no" name="passport_no"  type="text" placeholder="Enter Passport Number" />
        </div>


        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Enter Sur Name</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->sur_name:""}}" id="sur_name" name="sur_name" type="text" placeholder="Enter Sur Name"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Given Name</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->given_names:""}}" id="given_names" name="given_names" type="text" placeholder="Enter Given Name"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Father Name</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->father_name:""}}" id="father_name" name="father_name" type="text" placeholder="Enter Father_name"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Date Of Birth</label>
            <input class="form-control form-control"  value="{{isset($edit_passport)?$edit_passport->dob:""}}" id="dob" name="dob" type="text" placeholder="Enter Date of Birth"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Place of Birth</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->place_birth:""}}" id="place_birth" name="place_birth" type="text" placeholder="Enter Place Of Birth"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Place of Issue</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->place_issue:""}}" id="place_issue" name="place_issue" type="text" placeholder="Enter Place Of Issue"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Date of Issue</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->date_issue:""}}" id="date_issue" name="date_issue" type="text" placeholder="Enter Date of Issue"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Expiry Date</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->date_expiry:""}}" id="date_expiry" name="date_expiry" type="text" placeholder="Enter Expiry Date"  />
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Scanned Copy</label><br>
            @if(isset($edit_passport))
                <br>

                <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->passport_pic:""}}" id="temp_file" name="temp_file" type="hidden"   />

                <a class="attachment_display" href="{{ isset($edit_passport->passport_pic) ? url($edit_passport->passport_pic) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">Scanned Copy</strong></a>
            @endif
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category" id="copy_label">Photo</label>
            <div class="custom-file">
                <input class="form-control custom-file-input" id="emirates_pic" type="file" name="file_name" />
                <label class="custom-file-label" for="select_file">Choose Scanned Copy</label>
            </div>
        </div>

        <div class="col-md-3 form-group mb-3 citizenship_number" id="citizenship_number">
            <label for="repair_category">Citizenship Number</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->citizenship_no:""}}" id="citizenship_no" name="citizenship_no"  type="text" placeholder="Enter Citizenship Number"  />
        </div>

        <div class="col-md-3 form-group mb-3 personal_add" id="personal_add">
            <label for="repair_category">Personal Address</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->personal_address:""}}" id="personal_address" name="personal_address"  type="text" placeholder="Enter Personal Address"  />
        </div>

        <div class="col-md-3 form-group mb-3 permanant_add" id="permanant_add">
            <label for="repair_category">Permanant Address</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->permanant_address:""}}" id="permanant_address" name="permanant_address"  type="text" placeholder="Enter Permanant Address" />
        </div>


        <div class="col-md-3 form-group mb-3 booklet_no"id="booklet_no">
            <label for="repair_category">Booklet Number</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->booklet_number:""}}" id="booklet_number" name="booklet_number" type="text" placeholder="Enter Booklet Number"  />
        </div>
        <div class="col-md-3 form-group mb-3 tracking_no" id="tracking_no">
            <label for="repair_category">Tracking Number</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->tracking_number:""}}" id="tracking_number" name="tracking_number" type="text" placeholder="Enter Tracking Number"  />
        </div>
        <div class="col-md-3 form-group mb-3 mother_name" id="mother_name">
            <label for="repair_category">Name of Mother</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->name_of_mother:""}}" id="name_of_mother" name="name_of_mother" type="text" placeholder="Enter Father_name"  />
        </div>
        <div class="col-md-3 form-group mb-3 next_kin" id="next_kin">
            <label for="repair_category">Next of Kin</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->next_of_kin:""}}" id="next_of_kin" name="next_of_kin" type="text" placeholder="Enter Next of Kin"  />
        </div>
        <div class="col-md-3 form-group mb-3 relation" id="relation">
            <label for="repair_category">Relationship</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->relationship:""}}" id="relationship" name="relationship" type="text" placeholder="Enter Relationship"  />
        </div>
        <div class="col-md-3 form-group mb-3 name_middle" id="name_middle">
            <label for="repair_category">Middle Name</label>
            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->middle_name:""}}" id="middle_name" name="middle_name" type="text" placeholder="Middle Name"  />
        </div>
        <div class="col-md-3 form-group mb-3 name_middle" id="attachment_name">
            <label for="repair_category">Attachement Name</label>
{{--            @if(isset($edit_passport))--}}
{{--                <input type="hidden" id="attachment_name" name="attachment_name" value="{{isset($edit_passport)?$edit_passport->attach->attachment_name:""}}">--}}
{{--            @endif--}}
{{--            <select id="attachment_name1" name="attachment_name" class="form-control cls_card_type">--}}

{{--                @php--}}
{{--                    $isSelected=(isset($edit_passport)?$edit_passport:"")==isset($edit_passport->attachment_name);--}}
{{--                @endphp--}}
{{--                <option value="" selected disabled>Select option</option>--}}
{{--                @foreach($attachment as $attach)--}}
{{--                <option value="1" {{ $isSelected ? 'selected': '' }}>{{isset($attach)?$attach->name:""}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}


            @if(isset($edit_passport))
                <input type="hidden" id="attachment_name" name="attachment_name" value="{{isset($edit_passport)?$edit_passport->id:""}}">
            @endif
            <select id="attachment_name1" name="attachment_name" class="form-control form-control-rounded">
                <option value="">Select the Part Number</option>
                @foreach($attachment as $attach)
                    @php
                        $isSelected=(isset($edit_passport)?$edit_passport->attachment_name:"")==$attach->id;
                    @endphp
                    <option value="{{$attach->id}}" {{ $isSelected ? 'selected': '' }}>{{$attach->name}}</option>
                @endforeach
            </select>


{{--            <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->attachment_name:""}}" id="attachment_name" name="attachment_name" type="text" placeholder="attachment_name"  />--}}
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category">Attachment Copy</label><br>
            @if(isset($edit_passport->attach->attachment_name))
                <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->attach->attachment_name:""}}" id="temp_file2" name="temp_file2" type="hidden"   />
            @endif
            @if(isset($edit_passport))
                <br>
                <input value="{{isset($edit_passport)?$edit_passport->attachment_id:""}}" id="attachment_id" name="attachment_id"  type="hidden"/>
                <a class="attachment_display" href="{{ isset($edit_passport->attach->attachment_name) ? url($edit_passport->attach->attachment_name) : ''  }}" id="passport_image" target="_blank">
                    <strong style="color: blue">Attachment Copy</strong></a>
            @endif
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="repair_category" id="copy_label">Photo</label>
            <div class="custom-file">
                <input class="form-control custom-file-input" id="attachment_copy" type="file" name="file_name3" />
                <label class="custom-file-label" for="select_file">Choose Attachment Copy</label>
            </div>
        </div>







            <div class="col-md-12 form-group mb-3">
                <h5>Passport Addtional Details</h5><br>
                <h6><strong>National Detail</strong></h6>
            </div>

            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">National Name</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->nat_name:""}}" id="nat_name" name="nat_name"  type="text" placeholder="Enter National Name"  />
                <input value="{{isset($edit_additional)?$edit_additional->id:""}}" id="additional_id" name="additional_id"  type="hidden"/>
            </div>

            <div class="col-md-3 form-group mb-3">
                <label for="repair_category"> National Relation</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->nat_relation:""}}" id="nat_relation" name="nat_relation"  type="text" placeholder="Enter Relation Name" />
            </div>


            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">National Address</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->nat_address:""}}" id="nat_address" name="nat_address" type="text" placeholder="Enter Address"  />
            </div>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">National Phone</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->nat_phone:""}}" id="nat_phone" name="nat_phone" type="text" placeholder="Enter Phone"  />
            </div>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">National WhatsApp</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->nat_whatsapp_no:""}}" id="nat_whatsapp_no" name="nat_whatsapp_no" type="text" placeholder="Enter WhatsApp"  />
            </div>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">National Email</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->nat_email:""}}" id="nat_email" name="nat_email" type="email" placeholder="Enter Email"  />
            </div>

            <div class="col-md-12 form-group mb-3">

                <h6><strong>Internatioan Detail</strong></h6>
            </div>

            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">International Name</label>
                <input class="form-control form-control" value="{{isset($edit_passport)?$edit_passport->inter_name:""}}" id="inter_name" name="inter_name" type="text" placeholder="Enter International Name"  />
            </div>

            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">International Relation</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->inter_relation:""}}" id="inter_relation" name="inter_relation" type="text" placeholder="Enter International Relation"  />
            </div>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">International Address</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->inter_address:""}}" id="inter_address" name="inter_address" type="text" placeholder="Enter Address"  />
            </div>


            <div class="col-md-3 form-group mb-3" id="citizenship_number">
                <label for="repair_category">International Phone</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->inter_phone:""}}" id="inter_phone" name="inter_phone"  type="text" placeholder="Enter International Phone"  />
            </div>

            <div class="col-md-3 form-group mb-3" id="personal_add">
                <label for="repair_category">International WhatsApp</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->inter_whatsapp_no:""}}" id="inter_whatsapp_no" name="inter_whatsapp_no"  type="text" placeholder="Enter Internatioanl WhatsApp"  />
            </div>

            <div class="col-md-3 form-group mb-3" id="permanant_add">
                <label for="repair_category">International Email</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->inter_email:""}}" id="inter_email" name="inter_email"  type="email" placeholder="Enter International Email" />
            </div>



            <div class="col-md-12 form-group mb-3" id="permanant_add">
                <h6><strong>Personal Info</strong></h6>
            </div>

            <div class="col-md-3 form-group mb-3"id="booklet_no">
                <label for="repair_category">Personal Mobile Number</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->personal_mob:""}}" id="personal_mob" name="personal_mob" type="text" placeholder="Enter Personal Mobile "  />
            </div>
            <div class="col-md-3 form-group mb-3" id="tracking_no">
                <label for="repair_category">Personal Email</label>
                <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->personal_email:""}}" id="personal_email" name="personal_email" type="gmail" placeholder="Enter Persnoal Email"  />
            </div>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category">Personal Image</label><br>
                @if(isset($edit_additional))
                    <br>
                    <input class="form-control form-control" value="{{isset($edit_additional)?$edit_additional->personal_image:""}}" id="temp_file" name="temp_file" type="hidden"  required />
                    <a class="attachment_display" href="{{ isset($edit_additional->personal_image)? url($edit_additional->personal_image):""}}" id="passport_image" target="_blank"><strong style="color: blue">Personal Image</strong></a>
                @endif
            </div>
            <div class="col-md-3 form-group mb-3">
                <label for="repair_category" id="copy_label">Personal Image</label>
                <div class="custom-file">
                    <input class="form-control custom-file-input" id="personal_img" type="file" name="file_name2" />
                    <label class="custom-file-label" for="select_file">Choose Persnoal Image</label>
                </div>
            </div>


            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" > Save  </button>
            </div>








</form>


<script>

    tail.DateTime("#dob",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,

    }).on("change", function(){
        tail.DateTime("#dob",{
            dateStart: $('#start_tail').val(),
            dateFormat: "YYYY-mm-dd",
            timeFormat: false

        }).reload();

    });


    tail.DateTime("#date_issue",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,

    }).on("change", function(){
        tail.DateTime("#date_expiry",{
            dateStart: $('#date_issue').val(),
            dateFormat: "YYYY-mm-dd",
            timeFormat: false

        }).reload();

    });

    tail.DateTime("#date_expiry",{
        dateFormat: "YYYY-mm-dd",
        timeFormat: false,

    }).on("change", function(){
        tail.DateTime("#date_expiry",{
            dateStart: $('#date_issue').val(),
            dateFormat: "YYYY-mm-dd",
            timeFormat: false

        }).reload();

    });
</script>
