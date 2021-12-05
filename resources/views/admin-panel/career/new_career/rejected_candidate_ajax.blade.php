@if($request_type=="1")
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active"  data-status="0" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Rejected From Front Desk</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="5"  id="home-basic-new_taken" data-toggle="tab" href="#new_taken" role="tab" aria-controls="new_taken" aria-selected="true">Rejected From Wait List</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="4" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Rejected From Selected</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="333" id="onboard-basic-tab" data-toggle="tab" href="#onboardTab" role="tab" aria-controls="onboardTab" aria-selected="false">Rejected From Onboard</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="other" id="other-basic-tab" data-toggle="tab" href="#otherTab" role="tab" aria-controls="otherTab" aria-selected="false">Rejected From Other Area</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="forntdesk_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>

                                </thead>
                                <tbody>


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
                                        <?php  $created_at = explode(" ", $career->created_at);?>

                                        <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>
                                        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
                                        <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
                                        <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
                                        <td>
                                            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            |

                                            @if(isset($career->passport_ppuid))
                                                        @if($career->cancel_status=="1")
                                                        <h4 class="badge badge-danger">PPUID Cancelled</h4>
                                                        @else
                                                        <a class="text-success mr-2 change_status_cls"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                                        @endif
                                             @else
                                             <a class="text-success mr-2 change_status_cls"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                             @endif


                                        </td>
                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--first tab work finished--}}
                    <div class="tab-pane fade show " id="new_taken" role="tabpanel" aria-labelledby="home-basic-new_taken">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="waitlist_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_waitlist"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>


                    </div>
                    {{--                    second tab work finished--}}

                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="selected_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_selected"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--                    third tab work finished--}}

                    <div class="tab-pane fade show" id="onboardTab" role="tabpanel" aria-labelledby="onboard-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="onboard_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_onboard"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>   {{-- fourth tab work finished--}}

                    <div class="tab-pane fade show" id="otherTab" role="tabpanel" aria-labelledby="other-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="other_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll_other"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" class="filtering_source_from">Source type</th>
                                    <th scope="col"  >Heard About us</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>   {{-- fourth tab work finished--}}

                </div>

                {{-- rejoin candidate work start --}}
                @else


                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-10 active"  data-status="8" id="rejoin_home-basic-tab" data-toggle="tab" href="#rejoin_homeBasic" role="tab" aria-controls="rejoin_homeBasic" aria-selected="true">Rejoin Rejected From Wait List</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="9"  id="rejoin_home-basic-new_taken" data-toggle="tab" href="#rejoin_new_taken" role="tab" aria-controls="rejoin_new_taken" aria-selected="true">Rejoin Rejected From Selected</a></li>
                    <li class="nav-item"><a class="nav-link text-10" data-status="10" id="rejoin_profile-basic-tab" data-toggle="tab" href="#rejoin_profileBasic" role="tab" aria-controls="rejoin_profileBasic" aria-selected="false">Rejoin Rejected From Onboard</a></li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="rejoin_homeBasic" role="tabpanel" aria-labelledby="rejoin_home-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="rejoin_forntdesk_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" >Action</th>
                                </tr>

                                </thead>
                                <tbody>


                                @foreach($wait_list as $career)
                                    <tr id="row-{{ $career->id }}">
                                        <td>
                                            <label class="checkbox checkbox-outline-primary text-10">
                                                <input type="checkbox"  data-email="{{ $career->id }}" name="checkbox_array[]" class="company_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td id="name-{{ $career->id }}">{{ $career->passport_detail->personal_info->full_name  }}</td>
                                        <td  id="email-{{ $career->id }}">{{ $career->passport_detail->personal_info->personal_email  }}</td>
                                        <td id="phone-{{ $career->id }}" >{{ $career->passport_detail->personal_info->inter_phone  }}</td>
                                        <td id="whatsapp-{{ $career->id }}" >{{ $career->passport_detail->personal_info->personal_mob }}</td>



                                        {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}
                                        <?php  $created_at = explode(" ", $career->created_at);?>

                                        <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>
                                        <td>
                                            <a class="text-primary mr-2 view_cls_rejoin" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                            |

                                            @if(isset($career->passport_ppuid))
                                                        @if($career->cancel_status=="1")
                                                        <h4 class="badge badge-danger">PPUID Cancelled</h4>
                                                        @else
                                                        <a class="text-success mr-2 change_status_cls_rejoin"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                                        @endif
                                             @else
                                             <a class="text-success mr-2 change_status_cls_rejoin"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                                             @endif


                                        </td>
                                    </tr>
                                @endforeach



                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--first tab work finished--}}
                    <div class="tab-pane fade show " id="rejoin_new_taken" role="tabpanel" aria-labelledby="rejoin_home-basic-new_taken">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="rejoin_waitlist_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>


                    </div>
                    {{--                    second tab work finished--}}

                    <div class="tab-pane fade show" id="rejoin_profileBasic" role="tabpanel" aria-labelledby="rejoin_profile-basic-tab">

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="rejoin_selected_datatable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"   id="checkAll"><span>All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col" class="filtering_source_from">Whats App</th>
                                    <th scope="col"  class="filtering_source_from" >Created At</th>
                                    <th scope="col" >Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    {{--                    third tab work finished--}}





                </div>


                @endif
