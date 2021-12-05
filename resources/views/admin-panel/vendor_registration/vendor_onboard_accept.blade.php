
@if($status=="1")
    @foreach($vendor_accept as $row)
            <tr>
                <td>{{ $row->created_at}} </td>
                <td>
                    @if (isset($row->applying_for) && $row->applying_for=='1')
                    <span class="badge badge-primary m-2">Bike</span>
                    @elseif(isset($row->applying_for) && $row->applying_for=='2')
                    <span class="badge badge-success m-2">Car</span>
                    @elseif(isset($row->applying_for) && $row->applying_for=='3')
                    <span class="badge badge-info m-2">Both</span>

                    @endif
                </td>
                <td> {{isset($row->rider_first_name)?$row->rider_first_name:"N/A"}}</td>
                <td> {{isset($row->rider_last_name)?$row->rider_last_name:"N/A"}}</td>
                <td> {{isset($row->contact_official)?$row->contact_official:"N/A"}}</td>
                <td> {{isset($row->contacts_personal)?$row->contacts_personal:"N/A"}}</td>
                <td> {{isset($row->contacts_email)?$row->contacts_email:"N/A"}}</td>
                <td> {{ $row->vendor ? $row->vendor->name: $row->four_pl_name }}</td>
                <td> {{isset($row->four_pl_code)?$row->four_pl_code:"N/A"}}</td>
                <td> {{isset($row->emirates_id_no)?$row->emirates_id_no:"N/A"}}</td>
                <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
                <td> {{isset($row->driving_license_no)?$row->driving_license_no:"N/A"}}</td>

                <td> {{isset($row->plate_no)?$row->plate_no:"N/A"}}</td>
                <td> {{isset($row->nation->name)?$row->nation->name:"N/A"}}</td>
                <td> {{isset($row->dob)?$row->dob:"N/A"}}</td>
                <td> {{isset($row->city)?$row->city:"N/A"}}</td>
                <td> {{isset($row->address)?$row->address:"N/A"}}</td>
                <td>
                    @if (isset($row->vaccine) && $row->vaccine=='1')
                    <a class="badge badge-success m-2" href="#">1st Dose Taken</a>
                    @elseif(isset($row->vaccine) && $row->vaccine=='2')
                    <a class="badge badge-primary m-2" href="#">2nd Dose Taken</a>
                    @elseif(isset($row->vaccine) && $row->vaccine=='3')
                    <a class="badge badge-danger m-2" href="#">Not Yet</a>
                    @else
                            N/A
                    @endif
                    </td>

                    <td>  <a class="attachment_display" href="{{ $row->passport_copy ? Storage::temporaryUrl($row->passport_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Passport Copy</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->visa_copy ? Storage::temporaryUrl($row->visa_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Visa Copy</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_side ? Storage::temporaryUrl($row->emirates_id_front_side, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Side</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_back ? Storage::temporaryUrl($row->emirates_id_front_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Back</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->driving_license_front ? Storage::temporaryUrl($row->driving_license_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Front</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->driving_license_back ? Storage::temporaryUrl($row->driving_license_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Back</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->health_insurance_card_copy ? Storage::temporaryUrl($row->health_insurance_card_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Health Insurance Card Copy</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->mulkiya_front ? Storage::temporaryUrl($row->mulkiya_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Mulkiya Front</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->mulkiya_back ? Storage::temporaryUrl($row->mulkiya_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Mulkiya Back</strong></a></td>
                    <td>  <a class="attachment_display" href="{{ $row->rider_photo ? Storage::temporaryUrl($row->rider_photo, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Rider Photo</strong></a></td>
                            <td>  <a class="attachment_display" href="{{ $row->vaccination_card ? Storage::temporaryUrl($row->vaccination_card, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Vaccination Card</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->box_pic ? Storage::temporaryUrl($row->box_pic, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Box installation Pic</strong></a></td>
                    <td><a href="{{route('vendor-onboard-edit', $row->id)}}" class="btn btn-primary">Update</a></td>
            </tr>
    @endforeach
    @elseif ($status=="0")
    @foreach($vendor_new as $row)
    <tr>
        <td>{{ $row->created_at}} </td>
        <td>
             @if (isset($row->applying_for) && $row->applying_for=='1')
            <span class="badge badge-primary m-2">Bike</span>
            @elseif(isset($row->applying_for) && $row->applying_for=='2')
            <span class="badge badge-success m-2">Car</span>
            @elseif(isset($row->applying_for) && $row->applying_for=='3')
            <span class="badge badge-info m-2">Both</span>

            @endif
    </td>
        <td> {{isset($row->rider_first_name)?$row->rider_first_name:"N/A"}}</td>
        <td> {{isset($row->rider_last_name)?$row->rider_last_name:"N/A"}}</td>
        <td> {{isset($row->contact_official)?$row->contact_official:"N/A"}}</td>
        <td> {{isset($row->contacts_personal)?$row->contacts_personal:"N/A"}}</td>
        <td> {{isset($row->contacts_email)?$row->contacts_email:"N/A"}}</td>
        <td> {{ $row->vendor ? $row->vendor->name: $row->four_pl_name }}</td>
        <td> {{isset($row->four_pl_code)?$row->four_pl_code:"N/A"}}</td>
        <td> {{isset($row->emirates_id_no)?$row->emirates_id_no:"N/A"}}</td>
        <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
        <td> {{isset($row->driving_license_no)?$row->driving_license_no:"N/A"}}</td>

        <td> {{isset($row->plate_no)?$row->plate_no:"N/A"}}</td>
        <td> {{isset($row->nation->name)?$row->nation->name:"N/A"}}</td>
        <td> {{isset($row->dob)?$row->dob:"N/A"}}</td>
        <td> {{isset($row->city)?$row->city:"N/A"}}</td>
        <td> {{isset($row->address)?$row->address:"N/A"}}</td>
        <td>
            @if (isset($row->vaccine) && $row->vaccine=='1')
            <a class="badge badge-success m-2" href="#">1st Dose Taken</a>
            @elseif(isset($row->vaccine) && $row->vaccine=='2')
            <a class="badge badge-primary m-2" href="#">2nd Dose Taken</a>
            @elseif(isset($row->vaccine) && $row->vaccine=='3')
            <a class="badge badge-danger m-2" href="#">Not Yet</a>
            @else
                    N/A
            @endif
            </td>
        <td> {{$row->previous_company?$row->previous_company:"N/A"}}</td>
        <td> {{$row->previous_platform?$row->previous_platform:"N/A"}}</td>
        <td> {{$row->previous_rider_id?$row->previous_rider_id:"N/A"}}</td>

        <td>  <a class="attachment_display" href="{{ $row->passport_copy ? Storage::temporaryUrl($row->passport_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Passport Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->visa_copy ? Storage::temporaryUrl($row->visa_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Visa Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_side ? Storage::temporaryUrl($row->emirates_id_front_side, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Side</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_back ? Storage::temporaryUrl($row->emirates_id_front_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->driving_license_front ? Storage::temporaryUrl($row->driving_license_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Front</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->driving_license_back ? Storage::temporaryUrl($row->driving_license_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->health_insurance_card_copy ? Storage::temporaryUrl($row->health_insurance_card_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Health Insurance Card Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->mulkiya_front ? Storage::temporaryUrl($row->mulkiya_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Mulkiya Front</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->mulkiya_back ? Storage::temporaryUrl($row->mulkiya_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Mulkiya Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->rider_photo ? Storage::temporaryUrl($row->rider_photo, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Rider Photo</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->vaccination_card ? Storage::temporaryUrl($row->vaccination_card, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Vaccination Card</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->box_pic ? Storage::temporaryUrl($row->box_pic, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Box installation Pic</strong></a></td>
        <td>
            <button class="btn btn-success ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
            <button class="btn btn-danger ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

        </td>
    </tr>
@endforeach

@elseif ($status=="2")

    @foreach($vendor_reject as $row)
        <tr>
            <td>{{ $row->created_at}} </td>
            <td>
                @if (isset($row->applying_for) && $row->applying_for=='1')
                <span class="badge badge-primary m-2">Bike</span>
                @elseif(isset($row->applying_for) && $row->applying_for=='2')
                <span class="badge badge-success m-2">Car</span>
                @elseif(isset($row->applying_for) && $row->applying_for=='3')
                <span class="badge badge-info m-2">Both</span>

                @endif
        </td>
            <td> {{isset($row->rider_first_name)?$row->rider_first_name:"N/A"}}</td>
            <td> {{isset($row->rider_last_name)?$row->rider_last_name:"N/A"}}</td>
            <td> {{isset($row->contact_official)?$row->contact_official:"N/A"}}</td>
            <td> {{isset($row->contacts_personal)?$row->contacts_personal:"N/A"}}</td>
            <td> {{isset($row->contacts_email)?$row->contacts_email:"N/A"}}</td>
            <td> {{isset($row->four_pl_name)?$row->four_pl_name:"N/A"}}</td>
            <td> {{isset($row->four_pl_code)?$row->four_pl_code:"N/A"}}</td>
            <td> {{isset($row->emirates_id_no)?$row->emirates_id_no:"N/A"}}</td>
            <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
            <td> {{isset($row->driving_license_no)?$row->driving_license_no:"N/A"}}</td>

            <td> {{isset($row->plate_no)?$row->plate_no:"N/A"}}</td>
            <td> {{isset($row->nation->name)?$row->nation->name:"N/A"}}</td>
            <td> {{isset($row->dob)?$row->dob:"N/A"}}</td>
            <td> {{isset($row->city)?$row->city:"N/A"}}</td>
            <td> {{isset($row->address)?$row->address:"N/A"}}</td>

            <td>
                @if (isset($row->vaccine) && $row->vaccine=='1')
                <a class="badge badge-success m-2" href="#">1st Dose Taken</a>
                @elseif(isset($row->vaccine) && $row->vaccine=='2')
                <a class="badge badge-primary m-2" href="#">2nd Dose Taken</a>
                @elseif(isset($row->vaccine) && $row->vaccine=='3')
                <a class="badge badge-danger m-2" href="#">Not Yet</a>
                @else
                        N/A
                @endif
                </td>

                <td>  <a class="attachment_display" href="{{ $row->passport_copy ? Storage::temporaryUrl($row->passport_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Passport Copy</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->visa_copy ? Storage::temporaryUrl($row->visa_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Visa Copy</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_side ? Storage::temporaryUrl($row->emirates_id_front_side, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Side</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_back ? Storage::temporaryUrl($row->emirates_id_front_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Back</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->driving_license_front ? Storage::temporaryUrl($row->driving_license_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Front</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->driving_license_back ? Storage::temporaryUrl($row->driving_license_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Back</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->health_insurance_card_copy ? Storage::temporaryUrl($row->health_insurance_card_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Health Insurance Card Copy</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->mulkiya_front ? Storage::temporaryUrl($row->mulkiya_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Mulkiya Front</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->mulkiya_back ? Storage::temporaryUrl($row->mulkiya_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Mulkiya Back</strong></a></td>
                <td>  <a class="attachment_display" href="{{ $row->rider_photo ? Storage::temporaryUrl($row->rider_photo, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Rider Photo</strong></a></td>
            <td>
                <button class="btn btn-danger ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm-2" onclick="vendor_req_pending({{$row->id}})" type="button">Move To Pending</button>

            </td>
        </tr>
    @endforeach

@elseif ($status=="4")

    @foreach($vendor_rejoin as $row)
    <tr>
        <td>{{ $row->created_at}} </td>
        <td>
            @if (isset($row->applying_for) && $row->applying_for=='1')
            <span class="badge badge-primary m-2">Bike</span>
            @elseif(isset($row->applying_for) && $row->applying_for=='2')
            <span class="badge badge-success m-2">Car</span>
            @elseif(isset($row->applying_for) && $row->applying_for=='3')
            <span class="badge badge-info m-2">Both</span>

            @endif
    </td>
        <td> {{isset($row->rider_first_name)?$row->rider_first_name:"N/A"}}</td>
        <td> {{isset($row->rider_last_name)?$row->rider_last_name:"N/A"}}</td>
        <td> {{isset($row->contact_official)?$row->contact_official:"N/A"}}</td>
        <td> {{isset($row->contacts_personal)?$row->contacts_personal:"N/A"}}</td>
        <td> {{isset($row->contacts_email)?$row->contacts_email:"N/A"}}</td>
        <td> {{ $row->vendor ? $row->vendor->name: $row->four_pl_name }}</td>
        <td> {{isset($row->four_pl_code)?$row->four_pl_code:"N/A"}}</td>
        <td> {{isset($row->emirates_id_no)?$row->emirates_id_no:"N/A"}}</td>
        <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
        <td> {{isset($row->driving_license_no)?$row->driving_license_no:"N/A"}}</td>

        <td> {{isset($row->plate_no)?$row->plate_no:"N/A"}}</td>
        <td> {{isset($row->nation->name)?$row->nation->name:"N/A"}}</td>
        <td> {{isset($row->dob)?$row->dob:"N/A"}}</td>
        <td> {{isset($row->city)?$row->city:"N/A"}}</td>
        <td> {{isset($row->address)?$row->address:"N/A"}}</td>
        <td>
            @if (isset($row->vaccine) && $row->vaccine=='1')
            <a class="badge badge-success m-2" href="#">1st Dose Taken</a>
            @elseif(isset($row->vaccine) && $row->vaccine=='2')
            <a class="badge badge-primary m-2" href="#">2nd Dose Taken</a>
            @elseif(isset($row->vaccine) && $row->vaccine=='3')
            <a class="badge badge-danger m-2" href="#">Not Yet</a>
            @else
                    N/A
            @endif
            </td>



        <td>  <a class="attachment_display" href="{{ $row->passport_copy ? Storage::temporaryUrl($row->passport_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Passport Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->visa_copy ? Storage::temporaryUrl($row->visa_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Visa Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_side ? Storage::temporaryUrl($row->emirates_id_front_side, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Side</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_back ? Storage::temporaryUrl($row->emirates_id_front_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->driving_license_front ? Storage::temporaryUrl($row->driving_license_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Front</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->driving_license_back ? Storage::temporaryUrl($row->driving_license_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->health_insurance_card_copy ? Storage::temporaryUrl($row->health_insurance_card_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Health Insurance Card Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->mulkiya_front ? Storage::temporaryUrl($row->mulkiya_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Mulkiya Front</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->mulkiya_back ? Storage::temporaryUrl($row->mulkiya_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Mulkiya Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->rider_photo ? Storage::temporaryUrl($row->rider_photo, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Rider Photo</strong></a></td>
        <td>
            <button class="btn btn-success ven-btn"  onclick="vendor_req_accept_rejoin({{$row->id}})" type="button">Accept</button>
            <button class="btn btn-danger ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

        </td>
    </tr>
    @endforeach

@elseif ($status=="3")

    @foreach($vendor_reapply as $row)
    <tr>
        <td>{{$row->updated_at}} </td>
        <td>
            @if (isset($row->applying_for) && $row->applying_for=='1')
            <span class="badge badge-primary m-2">Bike</span>
            @elseif(isset($row->applying_for) && $row->applying_for=='2')
            <span class="badge badge-success m-2">Car</span>
            @elseif(isset($row->applying_for) && $row->applying_for=='3')
            <span class="badge badge-info m-2">Both</span>

            @endif
    </td>
        <td> {{isset($row->rider_first_name)?$row->rider_first_name:"N/A"}}</td>
        <td> {{isset($row->rider_last_name)?$row->rider_last_name:"N/A"}}</td>
        <td> {{isset($row->contact_official)?$row->contact_official:"N/A"}}</td>
        <td> {{isset($row->contacts_personal)?$row->contacts_personal:"N/A"}}</td>
        <td> {{isset($row->contacts_email)?$row->contacts_email:"N/A"}}</td>
        <td> {{ $row->vendor ? $row->vendor->name: $row->four_pl_name }}</td>
        <td> {{isset($row->four_pl_code)?$row->four_pl_code:"N/A"}}</td>
        <td> {{isset($row->emirates_id_no)?$row->emirates_id_no:"N/A"}}</td>
        <td> {{isset($row->passport_no)?$row->passport_no:"N/A"}}</td>
        <td> {{isset($row->driving_license_no)?$row->driving_license_no:"N/A"}}</td>

        <td> {{isset($row->plate_no)?$row->plate_no:"N/A"}}</td>
        <td> {{isset($row->nation->name)?$row->nation->name:"N/A"}}</td>
        <td> {{isset($row->dob)?$row->dob:"N/A"}}</td>
        <td> {{isset($row->city)?$row->city:"N/A"}}</td>
        <td> {{isset($row->address)?$row->address:"N/A"}}</td>
        <td>
            @if (isset($row->vaccine) && $row->vaccine=='1')
            <a class="badge badge-success m-2" href="#">1st Dose Taken</a>
            @elseif(isset($row->vaccine) && $row->vaccine=='2')
            <a class="badge badge-primary m-2" href="#">2nd Dose Taken</a>
            @elseif(isset($row->vaccine) && $row->vaccine=='3')
            <a class="badge badge-danger m-2" href="#">Not Yet</a>
            @else
                    N/A
            @endif
            </td>



        <td>  <a class="attachment_display" href="{{ $row->passport_copy ? Storage::temporaryUrl($row->passport_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Passport Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->visa_copy ? Storage::temporaryUrl($row->visa_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Visa Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_side ? Storage::temporaryUrl($row->emirates_id_front_side, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Side</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->emirates_id_front_back ? Storage::temporaryUrl($row->emirates_id_front_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Emirates ID Front Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->driving_license_front ? Storage::temporaryUrl($row->driving_license_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Front</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->driving_license_back ? Storage::temporaryUrl($row->driving_license_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Driving License Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->health_insurance_card_copy ? Storage::temporaryUrl($row->health_insurance_card_copy, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Health Insurance Card Copy</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->mulkiya_front ? Storage::temporaryUrl($row->mulkiya_front, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Mulkiya Front</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->mulkiya_back ? Storage::temporaryUrl($row->mulkiya_back, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Mulkiya Back</strong></a></td>
        <td>  <a class="attachment_display" href="{{ $row->rider_photo ? Storage::temporaryUrl($row->rider_photo, now()->addMinutes(5)) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">Rider Photo</strong></a></td>
        <td>
            <button class="btn btn-success ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
            <button class="btn btn-danger ven-btn" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

        </td>
    </tr>
    @endforeach

@endif
