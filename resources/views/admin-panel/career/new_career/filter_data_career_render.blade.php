@if($tab=="1" && $type=="wait_list")
@foreach($careers as $career)

    <tr id="row-{{ $career->id }}">
        <td>

            <label class="checkbox checkbox-outline-primary text-10">
                <input type="checkbox"  data-email="{{ $career->email }}" name="checkbox_array[]" class="company_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
            </label>
        </td>
        <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
        <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
        <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
        <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>

        <td>
            @if (isset($career->follow_up_status))
                @if ($career->follow_up_status == "1")
                    Interested
                @elseif ($career->follow_up_status == "2")
                    Call Me Tomorrow
                @elseif ($career->follow_up_status == "3")
                    No Response
                @elseif ($career->follow_up_status == "4")
                    Not Interested
                @elseif ($career->follow_up_status == "0")
                    Not Verified
                @endif
            @endif
        </td>

        {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


        <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>

        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
        </td>
    </tr>
@endforeach

 @elseif($tab=="2" && $type=="wait_list")
    @foreach($careers as $career)



        <tr id="row-{{ $career->id }}">
            <td>

                <label class="checkbox checkbox-outline-primary text-10">
                    <input type="checkbox" data-email="{{ $career->email }}" name="checkbox_array[]" class="fourpl_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                </label>
            </td>
            <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
            <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
            <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
            <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>

            <td>
                @if (isset($career->follow_up_status))
                    @if ($career->follow_up_status == "1")
                        Interested
                    @elseif ($career->follow_up_status == "2")
                        Call Me Tomorrow
                    @elseif ($career->follow_up_status == "3")
                        No Response
                    @elseif ($career->follow_up_status == "4")
                        Not Interested
                    @elseif ($career->follow_up_status == "0")
                        Not Verified
                    @endif
                @endif
            </td>

            {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


            <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>

            <td>
                <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
            </td>
        </tr>
    @endforeach

@elseif($tab=="2" && $type=="new_taken_wait_list")

    @foreach($new_taken_careers as $career)



        <tr id="row-{{ $career->id }}">
            <td>

                <label class="checkbox checkbox-outline-primary text-10">
                    <input type="checkbox"  data-email="{{ $career->email }}" name="checkbox_array[]" class="new_taken_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                </label>
            </td>
            <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
            <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
            <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
            <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>

            <td>
                @if (isset($career->follow_up_status))
                    @if ($career->follow_up_status == "1")
                        Interested
                    @elseif ($career->follow_up_status == "2")
                        Call Me Tomorrow
                    @elseif ($career->follow_up_status == "3")
                        No Response
                    @elseif ($career->follow_up_status == "4")
                        Not Interested
                    @elseif ($career->follow_up_status == "0")
                        Not Verified
                    @endif
                @endif
            </td>

            {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


            <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>

            <td>
                <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
            </td>
        </tr>
    @endforeach




@elseif($tab=="3" && $type=="new_taken_wait_list")


    @foreach($new_taken_careers as $career)



        <tr id="row-{{ $career->id }}">
            <td>

                <label class="checkbox checkbox-outline-primary text-10">
                    <input type="checkbox"  data-email="{{ $career->email }}" name="checkbox_array[]" class="new_taken_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                </label>
            </td>
            <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
            <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
            <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
            <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>

            <td>
                @if (isset($career->follow_up_status))
                    @if ($career->follow_up_status == "1")
                        Interested
                    @elseif ($career->follow_up_status == "2")
                        Call Me Tomorrow
                    @elseif ($career->follow_up_status == "3")
                        No Response
                    @elseif ($career->follow_up_status == "4")
                        Not Interested
                    @elseif ($career->follow_up_status == "0")
                        Not Verified
                    @endif
                @endif
            </td>

            {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}


            <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>

            <td>
                <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
            </td>
        </tr>
    @endforeach



@elseif($tab=="1" && $type=="selected_company")


    @foreach($company_rider as $career)


        <?php
        $passport_detail = isset($career->passport_detail) ? $career->passport_detail->passport_no : '0';
        ?>

        <tr id="row-{{ $career->id }}">
            <td>#</td>
            <td>

                <label class="checkbox checkbox-outline-primary text-10">
                    <input type="checkbox" data-email="{{ $career->email }}"   class="company_checkbox original_company_checkbox" name="checkbox_array[]" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                </label>
            </td>
            <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
            <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
            <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
            <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
            <td>
                @if (isset($career->follow_up_status))
                    @if ($career->follow_up_status == "1")
                        Interested
                    @elseif ($career->follow_up_status == "2")
                        Call Me Tomorrow
                    @elseif ($career->follow_up_status == "3")
                        No Response
                    @elseif ($career->follow_up_status == "4")
                        Not Interested
                    @elseif ($career->follow_up_status == "0")
                        Not Verified
                    @endif
                @endif
            </td>
            {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}

            <td id="created_at-{{ $career->id }}" >{{ $career->updated_at->toDateString() }}</td>
            <td><h5 class="badge badge-success">{{ $career->interview_pass() ? $career->interview_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->interview_failed() ? $career->interview_failed()  : '0'}}</h5></td>
            <td><h5 class="badge badge-success">{{ $career->training_pass() ? $career->training_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->training_fail() ? $career->training_fail()  : '0'}}</h5></td>

            <td>
                <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                @if($passport_detail!="0")
                    <h5 class="badge badge-info">PPUID Created</h5>
                @else
                    {{--                                                <a class="text-secondary mr-2 enter_passport" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Diploma-2 font-weight-bold"></i></a>--}}
                @endif
            </td>
        </tr>
    @endforeach

@elseif($tab=="2" && $type=="selected_fourpl")

    @foreach($four_pl_rider as $career)


        <?php
        $passport_detail = isset($career->passport_detail) ? $career->passport_detail->passport_no : '0';
        ?>

        <tr id="row-{{ $career->id }}" @if($passport_detail!="0") style="background-color: #72b972;" @endif>
            <td>#</td>
            <td>

                <label class="checkbox checkbox-outline-primary text-10">
                    <input type="checkbox" data-email="{{ $career->email }}"    class="four_pl_checkbox four_pl_orignial_checkbox" name="checkbox_array[]" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                </label>
            </td>
            <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
            <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
            <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
            <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
            <td>
                @if (isset($career->follow_up_status))
                    @if ($career->follow_up_status == "1")
                        Interested
                    @elseif ($career->follow_up_status == "2")
                        Call Me Tomorrow
                    @elseif ($career->follow_up_status == "3")
                        No Response
                    @elseif ($career->follow_up_status == "4")
                        Not Interested
                    @elseif ($career->follow_up_status == "0")
                        Not Verified
                    @endif
                @endif
            </td>
            {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}

            <td id="created_at-{{ $career->id }}" >{{  $career->updated_at->toDateString() }}</td>
            <td><h5 class="badge badge-success">{{ $career->interview_pass() ? $career->interview_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->interview_failed() ? $career->interview_failed()  : '0'}}</h5></td>
            <td><h5 class="badge badge-success">{{ $career->training_pass() ? $career->training_pass()  : '0'}}</h5> / <h5 class="badge badge-danger">{{ $career->training_fail() ? $career->training_fail()  : '0'}}</h5></td>

            <td>
                <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                @if($passport_detail!="0")
                    <h6 class="badge badge-success">PPUID Created</h6>
                @else
                    {{--                                                <a class="text-secondary mr-2 enter_passport" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Diploma-2 font-weight-bold"></i></a>--}}
                @endif
            </td>
        </tr>
    @endforeach



@endif
