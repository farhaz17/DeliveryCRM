@if($tab=="only_pass")

@foreach($referals as $row)

    @if(!isset($row->passport_detail))
        <tr id="{{  $row->id }}-ashir">
            <td>{{ $row->created_at->todatestring()  }}</td>
            <td>{{isset($row->refer_by_user->personal_info->full_name)?$row->refer_by_user->personal_info->full_name:"N/A"}}</td>

            <td>{{isset($row->refer_by_user->zds_code->zds_code)?$row->refer_by_user->zds_code->zds_code:"N/A"}}</td>
            <td>{{isset($row->refer_by_user->pp_uid)?$row->refer_by_user->pp_uid:"N/A"}}</td>

            <td>{{$row->name}}</td>
            <td>{{isset($row->phone)?$row->phone:"N/A"}}</td>
            <td>{{isset($row->whatsapp)?$row->whatsapp:"N/A"}}</td>

            <td>{{$row->passport_no}}</td>
            <td>{{$row->licence_no}}</td>

            <td>
                @if($row->status=='0')
                    Pending
                @elseif($row->status=='1')
                    Interview
                @elseif($row->status=='2')
                    Detail Collected
                @elseif($row->status=='3')
                    Hired
                @else
                @endif
                {{ isset($row->follow_status) ? $row->follow_status->name: 'N/A' }}

            </td>
            {{--                            <td>--}}
            {{--                                {{isset($row->credit_amount)?$row->credit_amount:"N/A"}}--}}
            {{--                            </td>--}}
            <td>
                @if($row->referal_status_reward=='1')
                    <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
                @else
                    <span class="font-weight-bold" style="color: #0a6aa1">No Reward Yet</span>
                @endif
            </td>
            <td>

                @if($tab=="only_pass")
                    <a class="text-secondary mr-2 enter_passport" id="{{ $row->id }}" href="javascript:void(0)"><i class="nav-icon i-Diploma-2 font-weight-bold"></i></a>
                @endif


                <a class="text-primary mr-2 view-btn" id="{{$row->refer_by}}"><i class="nav-icon i-Full-View-Window font-weight-bold"></i></a>

            </td>

        </tr>
        @endif
@endforeach

@elseif($tab=="hired")



                @foreach($referals as $row)

                <tr id="{{  $row->id }}-ashir">
                                <td>{{ $row->created_at->todatestring()  }}</td>
                                <td>{{isset($row->refer_by_user->personal_info->full_name)?$row->refer_by_user->personal_info->full_name:"N/A"}}</td>

                                <td>{{isset($row->refer_by_user->zds_code->zds_code)?$row->refer_by_user->zds_code->zds_code:"N/A"}}</td>
                                <td>{{isset($row->refer_by_user->pp_uid)?$row->refer_by_user->pp_uid:"N/A"}}</td>

                                <td>{{$row->name}}</td>
                                <td>{{isset($row->phone)?$row->phone:"N/A"}}</td>
                                <td>{{isset($row->whatsapp)?$row->whatsapp:"N/A"}}</td>

                                <td>{{$row->passport_no}}</td>
                                <td>{{$row->licence_no}}</td>

                                <td>
                                    @if($row->status=='0')
                                        Pending
                                    @elseif($row->status=='1')
                                        Interview
                                    @elseif($row->status=='2')
                                        Detail Collected
                                    @elseif($row->status=='3')
                                        Hired
                                    @else
                                    @endif
                                    {{ isset($row->follow_status) ? $row->follow_status->name: 'N/A' }}

                                </td>
                                {{--                            <td>--}}
                                {{--                                {{isset($row->credit_amount)?$row->credit_amount:"N/A"}}--}}
                                {{--                            </td>--}}
                                <td>


                                    <?php
                                    $is_refer_table = isset($row->referal_detail) ? $row->referal_detail : '';
                                    $is_paid_now = 0;
                                    if($is_refer_table != null){
                                        // dd( $is_refer_table->credit_status );
                                        if($is_refer_table->credit_status=="1"){
                                            $is_paid_now  = "1";
                                        }
                                    }

                                        ?>
                                    @if($is_paid_now=="1")
                                    <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
                                    @elseif($row->referal_status_reward=='1')
                                        <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
                                    @else
                                        <span class="font-weight-bold" style="color: #0a6aa1">No Reward Yet</span>
                                    @endif

                                </td>
                                <td>{{ ($is_paid_now=="1" || $row->referal_status_reward=='1') ? $row->updated_at->todatestring() : 'N/A' }}</td>
                                <td>


                                    @if($tab=="hired")
                                        @if($row->referal_status_reward!='1' && $is_paid_now=="0")
                                            <a href="javascript:void(0)" class="text-success mr-2 reward_btn" id="{{$row->id}}"><i class="nav-icon i-Firewall font-weight-bold"></i></a>
                                            @endif
                                    @endif


                                    <a class="text-primary mr-2 view-btn" id="{{$row->refer_by}}"><i class="nav-icon i-Full-View-Window font-weight-bold"></i></a>


                                </td>

                </tr>

                @endforeach



@else

    @foreach($referals as $row)

    <tr id="{{  $row->id }}-ashir">
        <td>{{ $row->created_at->todatestring()  }}</td>
        <td>{{isset($row->refer_by_user->personal_info->full_name)?$row->refer_by_user->personal_info->full_name:"N/A"}}</td>

        <td>{{isset($row->refer_by_user->zds_code->zds_code)?$row->refer_by_user->zds_code->zds_code:"N/A"}}</td>
        <td>{{isset($row->refer_by_user->pp_uid)?$row->refer_by_user->pp_uid:"N/A"}}</td>

        <td>{{$row->name}}</td>
        <td>{{isset($row->phone)?$row->phone:"N/A"}}</td>
        <td>{{isset($row->whatsapp)?$row->whatsapp:"N/A"}}</td>

        <td>{{$row->passport_no}}</td>
        <td>{{$row->licence_no}}</td>

        <td>
            @if($row->status=='0')
                Pending
            @elseif($row->status=='1')
                Interview
            @elseif($row->status=='2')
                Detail Collected
            @elseif($row->status=='3')
                Hired
            @else
            @endif
            {{ isset($row->follow_status) ? $row->follow_status->name: 'N/A' }}

        </td>
        {{--                            <td>--}}
        {{--                                {{isset($row->credit_amount)?$row->credit_amount:"N/A"}}--}}
        {{--                            </td>--}}
        <td>


            <?php
            $is_refer_table = isset($row->referal_detail) ? $row->referal_detail : '';
            $is_paid_now = 0;
            if($is_refer_table != null){
                // dd( $is_refer_table->credit_status );
                if($is_refer_table->credit_status=="1"){
                    $is_paid_now  = "1";
                }
            }

                ?>
            @if($is_paid_now=="1")
            <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
            @elseif($row->referal_status_reward=='1')
                <span class="font-weight-bold" style="color: #0a6aa1">Reward Collected</span>
            @else
                <span class="font-weight-bold" style="color: #0a6aa1">No Reward Yet</span>
            @endif

        </td>
        <td>


            @if($tab=="hired")
                @if($row->referal_status_reward!='1' && $is_paid_now=="0")
                    <a href="javascript:void(0)" class="text-success mr-2 reward_btn" id="{{$row->id}}"><i class="nav-icon i-Firewall font-weight-bold"></i></a>
                    @endif
             @endif


            <a class="text-primary mr-2 view-btn" id="{{$row->refer_by}}"><i class="nav-icon i-Full-View-Window font-weight-bold"></i></a>


        </td>

    </tr>

    @endforeach

@endif
