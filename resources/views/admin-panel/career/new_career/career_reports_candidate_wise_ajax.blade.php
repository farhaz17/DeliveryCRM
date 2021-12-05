@if($request_type=="1")


@foreach($careers as $career)
<tr>
    <td>{{ isset($career->passport_ppuid) ? $career->passport_ppuid->passport_no :  $career->passport_no }}</td>
    <td>{{ isset($career->passport_ppuid) ? $career->passport_ppuid->personal_info->full_name:  $career->name }}</td>
    <td>{{ isset($career->passport_ppuid) ? $career->passport_ppuid->pp_uid:  'N/A' }}</td>
    <td>{{ isset($career->whatsapp) ? $career->whatsapp:  'N/A' }} / {{ isset($career->phone) ? $career->phone:  'N/A' }} </td>
    <td>{{ isset($career->licence_status) ? $licence_status_array[$career->licence_status]:  'N/A' }} </td>
    <td>{{ isset($career->vehicle_type) ? $applying_for_array[$career->vehicle_type]: 'N/A' }} </td>
    <td>
        @if(isset($career->passport_ppuid))
            <?php $passport_hold = $career->passport_ppuid->check_passport_hold(); ?>
            <?php $passport_locker = $career->passport_ppuid->check_passport_locker(); ?>
                @if(isset($passport_hold))
                    Received
                 @elseif(isset($passport_locker))
                    Received in Locker
                 @endif
        @else
            Not Received
        @endif
    </td>

    <td>
        @if($career->applicant_status < 3)
            {{ isset($career->follow_status) ? $career->follow_status->name : '' }}
        @elseif($career->applicant_status=="5")
            Wait List
        @elseif($career->applicant_status=="4")
                <?php $check_on_board = $career->check_on_board(); ?>
                <?php $check_interview = $career->check_interview_or_not(); ?>
      <?php
        $assing_platform = "";
      if(isset($career->passport_ppuid)){
          $assing_platform = $career->passport_ppuid->assign_platforms_checkin();
      }
        ?>
               @if(isset($assing_platform->plateformdetail))
                   Assigned Platform
                @elseif(isset($check_on_board))
                    On Board
                 @elseif(isset($check_interview))
                    In Interview ({{ isset($check_interview->batch_info) ? $check_interview->batch_info->reference_number : ''   }})
                @else
                   Selected
                 @endif

        @endif
    </td>
    <td id="{{ isset($career->passport_ppuid) ? $career->passport_ppuid->id :  $career->passport_no }}">
    {{ (isset($assing_platform->passport_ppuid) && isset($assing_platform))  ? $assing_platform->plateformdetail->name : 'N/A'  }}
    <td>
    @if(isset($career->passport_ppuid))
         @if($career->passport_ppuid->agree_amount)
                <a href="javascript:void(0)" id="{{ $career->passport_ppuid->agree_amount->id }}" class="show_agreed_amount_cls">{{ $career->passport_ppuid->agree_amount->final_amount  }}</a>
          @else
             N/A
         @endif
    @else
    N/A
    @endif
    </td>

    <td>
        @if(isset($career->passport_ppuid))
            {{  isset($career->passport_ppuid->agree_amount) ? $career->passport_ppuid->agree_amount->created_at->toDateString(): 'N/A' }}
        @else
            N/A
        @endif
    </td>
    <td>
        @if(isset($career->passport_ppuid))
            {{  isset($career->passport_ppuid->offer) ? $career->passport_ppuid->offer->date_time: 'N/A' }}
        @else
            N/A
        @endif
    </td>
    <td>
        <a class="text-primary mr-2 show_slider_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Letter-Sent font-weight-bold"></i></a>
    </td>

</tr>
@endforeach



@elseif($request_type=="0")

@foreach($rejoins as $career)
<tr>
    <td>{{ isset($career->passport_detail) ? $career->passport_detail->passport_no : "N/A" }}</td>
    <td>{{ isset($career->passport_detail) ? $career->passport_detail->personal_info->full_name:  'N/A' }}</td>
    <td>{{ isset($career->passport_detail) ? $career->passport_detail->passport_no:  'N/A' }}</td>
    <td>{{ isset($career->passport_detail) ? $career->passport_detail->personal_info->personal_mob:  'N/A' }} / {{ isset($career->passport_detail->personal_info->inter_phone) ? $career->passport_detail->personal_info->inter_phone:  'N/A' }} </td>
    <td>{{ isset($career->licence_status) ? $licence_status_array[$career->licence_status]:  'N/A' }} </td>
    <td>{{ isset($career->vehicle_type) ? $applying_for_array[$career->vehicle_type]: 'N/A' }} </td>
    <td>

        @if(isset($career->passport_detail))
        <?php $passport_hold = $career->passport_detail->check_passport_hold(); ?>
        <?php $passport_locker = $career->passport_detail->check_passport_locker(); ?>
            @if(isset($passport_hold))
                Received
             @elseif(isset($passport_locker))
                Received in Locker
             @endif
    @else
        Not Received
    @endif


    </td>

    <td>


        @if($career->applicant_status=="5" && $career->on_board=="0")
            Wait List
        @elseif($career->applicant_status=="4" && $career->on_board=="0" )
            Selected
        @elseif($career->applicant_status=="10" && $career->on_board=="0")
        <?php $interview_in  = "1"; ?>
          Interview
          <?php $interview_batch  = $career->interviews ?  $career->interviews : 'N/A' ;

          if(isset($interview_batch)){
            echo  "(".$career->check_interview_or_not()->batch_info->reference_number.")";
          }
           ?>
       @elseif($career->on_board=="1")

       <?php  $on_board_now =  ""; ?>
       @if(isset($career->passport_detail->on_board_details))

       <?php  $on_board_now  =  $career->passport_detail->on_board_details->where('assign_platform','=','1')
                    ->where('interview_status','=','1')
                     ->where('on_board','=','1')->first(); ?>

        <?php //  $on_board_now  =  $career->passport_detail->on_board_details ?  $career->passport_detail->on_board_details_check(): 'N/A'; ?>

        @endif


        @if(isset($on_board_now))
        Onboard
        @else

                        @if(isset($career->passport_detail->platform_assign))
                        <?php   $is_checkin = $career->passport_detail->assign_platforms_check() ?  $career->passport_detail->assign_platforms_check() : null; ?>

                                    @if(isset($is_checkin))
                                    {{  isset($is_checkin->plateformdetail->name) ? $is_checkin->plateformdetail->name  : null}}
                                    @else

                                    @endif
                         @else
                         "N/A"

                        @endif


        @endif

       @endif


    </td>
    <td id="{{ isset($career->passport_detail) ? $career->passport_detail->id :  $career->passport_no }}">
    {{ (isset($assing_platform->passport_ppuid) && isset($assing_platform))  ? $assing_platform->plateformdetail->name : 'N/A'  }}
    <td>
    @if(isset($career->passport_ppuid))
         @if($career->passport_ppuid->agree_amount)
                <a href="javascript:void(0)" id="{{ $career->passport_ppuid->agree_amount->id }}" class="show_agreed_amount_cls">{{ $career->passport_ppuid->agree_amount->final_amount  }}</a>
          @else
             N/A
         @endif
    @else
    N/A
    @endif
    </td>

    <td>
        @if(isset($career->passport_detail))
            {{  isset($career->passport_detail->agree_amount) ? $career->passport_detail->agree_amount->created_at->toDateString(): 'N/A' }}
        @else
            N/A
        @endif
    </td>
    <td>
        @if(isset($career->passport_detail))
            {{  isset($career->passport_detail->offer) ? $career->passport_detail->offer->date_time: 'N/A' }}
        @else
            N/A
        @endif
    </td>
    <td>
        <a class="text-primary mr-2 rejoin_slider_cls" id="{{ $career->passport_detail->id  }}" href="javascript:void(0)"><i class="nav-icon i-Letter-Sent font-weight-bold"></i></a>
    </td>

</tr>
@endforeach

@endif
