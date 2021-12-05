<div class="row">
    <div class="col-md-6">
        <div class="table-responsive modal_table">
            <h6>Passport Detail</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Nationality</th>
                    <td><span >{{ isset($passport->nation->name) ? $passport->nation->name : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Country Code</th>
                    <td><span>{{ isset($passport->country_code) ? $passport->country_code : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Passport Number</th>
                    <td><span>{{ isset($passport->passport_no)?$passport->passport_no:'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>SurName</th>
                    <td><span>{{ isset($passport->sur_name) ? $passport->sur_name : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Given Name</th>
                    <td><span>{{ isset($passport->given_names) ? $passport->given_names : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Sex</th>
                    <td><span>{{ isset($passport->sex) ? $passport->sex : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Father Name</th>
                    <td><span>{{ isset($passport->father_name) ? $passport->father_name : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Date Of Birth</th>
                    <td><span>{{ isset($passport->dob) ? $passport->dob : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Place of Birth</th>
                    <td><span>{{ isset($passport->place_birth) ? $passport->place_birth : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Place of Issue</th>
                    <td>{{ isset($passport->place_issue) ? $passport->place_issue : 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Place of Issue</th>
                    <td>{{ isset($passport->place_issue) ? $passport->place_issue : 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Date of Issue</th>
                    <td>{{ isset($passport->date_issue) ? $passport->date_issue : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Expiry Date</th>
                    <td>{{ isset($passport->date_expiry) ? $passport->date_expiry : 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Passport Scan Copy</th>
                    <td>
                        @if(isset($passport->passport_pic))
                            <a  href="{{ url($passport->passport_pic) }}"  target="_blank">See Attachment</a>
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                </tr>
                @if(!empty($passport->attach->attachment_name) && isset($passport->attachment_type->name))
                    <tr>
                        <th>{{ $passport->attachment_type->name }} Picture</th>
                        <td><a  href="{{ url($passport->attach->attachment_name) }}" target="_blank">See Attachment</a></td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="table-responsive modal_table">
            <h6>National Detail</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Relation Name</th>
                    <td><span>{{ isset($passport->personal_info->nat_name) ? $passport->personal_info->nat_name : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Relation</th>
                    <td><span>{{ isset($passport->personal_info->nat_relation) ? $passport->personal_info->nat_relation : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>National Address</th>
                    <td><span>{{ isset($passport->personal_info->nat_address) ? $passport->personal_info->nat_address : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>National Phone</th>
                    <td><span>{{ isset($passport->personal_info->nat_phone) ? $passport->personal_info->nat_phone : 'N/A' }}</span></td>

                </tr>
                <tr>
                    <th>National Whatsapp Number</th>
                    <td><span>{{ isset($passport->personal_info->nat_whatsapp_no) ? $passport->personal_info->nat_whatsapp_no : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>National Email Address</th>
                    <td><span>{{ isset($passport->personal_info->nat_email) ? $passport->personal_info->nat_email : 'N/A' }}</span></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="table-responsive modal_table">
            <h6>Passport Additional Detail</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Citizenship Number</th>
                    <td><span>{{ isset($passport->citizenship_no) ? $passport->citizenship_no : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Personal Address</th>
                    <td><span>{{ isset($passport->personal_address) ? $passport->personal_address : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Permanent Address</th>
                    <td><span>{{ isset($passport->permanant_address) ? $passport->permanant_address : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Booklet Numebr</th>
                    <td><span>{{ isset($passport->booklet_number) ? $passport->booklet_number : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Tracking Number</th>
                    <td><span>{{ isset($passport->tracking_number) ? $passport->tracking_number : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Name of Mother</th>
                    <td><span>{{ isset($passport->name_of_mother) ? $passport->name_of_mother : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Next Of Kind</th>
                    <td><span>{{ isset($passport->next_of_kin) ? $passport->next_of_kin : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Relationship</th>
                    <td><span>{{ isset($passport->relationship) ? $passport->relationship : 'N/A' }}</span></td>
                </tr>

                <tr>
                    <th>Middle Name</th>
                    <td><span>{{ isset($passport->middle_name) ? $passport->middle_name : 'N/A' }}</span></td>
                </tr>
            </table>
        </div>
        <div class="table-responsive modal_table">
            <h6>Personal Details</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>Personal Mobile</th>
                    <td><span>{{ isset($passport->personal_info->personal_mob) ? $passport->personal_info->personal_mob : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Personal Email</th>
                    <td><span>{{ isset($passport->personal_info->personal_email) ? $passport->personal_info->personal_email : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>Personal Image</th>
                    <td>
                        @if(isset($passport->personal_info->personal_image))
                            <a  href="{{ url($passport->personal_info->personal_image) }}" target="_blank">See Attachment</a>
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
        <div class="table-responsive modal_table">
            <h6>International Details</h6>
            <table class="table table-bordered table-striped">
                <tr>
                    <th>International Name</th>
                    <td><span>{{ isset($passport->personal_info->inter_name) ? $passport->personal_info->inter_name : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>International Relation</th>
                    <td><span>{{ isset($passport->personal_info->inter_relation) ? $passport->personal_info->inter_relation : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>International Address</th>
                    <td><span>{{ isset($passport->personal_info->inter_address) ? $passport->personal_info->inter_address : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>International Phone</th>
                    <td><span>{{ isset($passport->personal_info->inter_phone) ? $passport->personal_info->inter_phone : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>International Whatsapp Number</th>
                    <td><span>{{ isset($passport->personal_info->inter_whatsapp_no) ? $passport->personal_info->inter_whatsapp_no : 'N/A' }}</span></td>
                </tr>
                <tr>
                    <th>International Email Address</th>
                    <td><span>{{ isset($passport->personal_info->inter_email) ? $passport->personal_info->inter_email : 'N/A' }}</span></td>
                </tr>
            </table>
        </div>
    </div>
</div>
