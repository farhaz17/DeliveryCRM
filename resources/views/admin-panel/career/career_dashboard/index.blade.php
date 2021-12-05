@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
        .border_cls{
            border-radius: inherit;
        }
        .hide_cls{
            display: none;
        }
        .active_cls{
            border: 2px solid #ffa500f2;
        }
        .bg_color_cls{
            background-color: #343529 !important;
        }
        .bg_color_clss{
            background-color: #f44336 !important;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item active" aria-current="page">Career Dashboard</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Conference text-white"></i>
                    <p class="p-0">Hiring Master</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="oparation-menu" data-child-menu-items="oparation-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Checked-User text-white"></i>
                    <p class="p-0">Hiring Operation</p>
                </a>
            </div>
        </div>

        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="agreed_amount"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Receipt-3  text-white"></i>
                    <p class="p-0">Hiring Report</p>
                </a>
            </div>
        </div>


    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="display: none">
        <div class="row">

            <?php  $hiring_master = ['Admin']; ?>

            @hasanyrole($hiring_master)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-danger fc-corner-left border_cls">
                    <a href="{{ route('career_heard_about_us.index') }}" target="_blank" class="card-body text-center p-2 text-white new_cls_process" >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">From where heard about us</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-danger fc-corner-left border_cls">
                    <a href="{{ route('career_document_name.index') }}"  target="_blank" class="card-body text-center p-2 text-white new_cls_process" >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">Career Document Name</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_clss fc-corner-left border_cls">
                    <a href="{{ route('frontdesk_follow_up') }}" target="_blank"  class="card-body text-center p-2 text-white new_cls_process" id="front_desk_follow_up">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Front Desk Follow Up</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_clss fc-corner-left border_cls">
                    <a href="{{ route('waitlist_follow_up') }}" target="_blank"  class="card-body text-center p-2 text-white new_cls_process" id="wait_list_follow_up">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Wait List Follow Up</span></a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_clss fc-corner-left border_cls">
                    <a href="{{ route('selected_follow_up') }}" target="_blank" class="card-body text-center p-2 text-white new_cls_process" id="selected_follow_up">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Selected Follow Up</span></a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_clss fc-corner-left border_cls">
                    <a href="{{ route('onboard_follow_up') }}" target="_blank" class="card-body text-center p-2 text-white new_cls_process" id="onboard_follow_up">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">OnBoard Follow Up</span>
                    </a>
                </div>
            </div>
                @endhasanyrole

        </div>
    </div>
    <div class="submenu"  id="oparation-menu-items">
        <div class="row">


            <?php  $candidate_process_array = ['Admin',
                                                'Hiring-pool',
                                                 'Hiring-add-candidate-on-call',
                                                 'Hiring-add-international-candidate',
                                                 'Hiring-add-walkin-candidate',
                                                 'checkout_type_report',
                                                  'Hiring-Re-Entry',
                                                  'AgreedAmount',
                                                  'Send-direct-to-checkout' ]; ?>
            @hasanyrole($candidate_process_array)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="candidate_process">
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">Candidate Process</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $selection_process_array = ['Admin',
                                                'Hiring-pool',
                                                'Hiring-onboard-report',
                                                 'Hiring-front-desk',
                                                 'Hiring-selected-candidate',
                                                 'Rejection-report',
                                                 'Need_Licence',
                                                 'Missing_attachment_agreement'
                                                   ]; ?>


            @hasanyrole($selection_process_array)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="selection_process">
                        <i class="nav-icon i-Cursor-Select header-icon"></i>
                        <span class="item-name">Selection Process</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $interview_process_array = ['Admin',
            'Hiring-pool',
             'Hiring-create-new-interview-batch',
             'Hiring-interview-btach-report'
               ]; ?>

            @hasanyrole($interview_process_array)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="interview_process">
                        <i class="nav-icon i-Business-Man header-icon"></i>
                        <span class="item-name">Interview Process</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $referal_process_array = ['Admin',
            'Hiring-pool',
             'Hiring-referal-rewards'
               ]; ?>

            @hasanyrole($referal_process_array)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="referal_process">
                        <i class="nav-icon i-Business-Mens header-icon"></i>
                        <span class="item-name">Referal Process</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $board_process_array = ['Admin',
            'Hiring-pool',
             'Hiring-onboard-report',
             'waiting_for_training',
             'waiting_for_reservation',
               ]; ?>

            @hasanyrole($board_process_array)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="onboard_process">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Board Process</span>
                    </a>
                </div>
            </div>
            @endhasanyrole


            <?php  $followup_process_array = ['Admin',
            'Hiring-pool',
            'Hiring-followup',
               ]; ?>

            @hasanyrole($followup_process_array)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="career_followup">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Career Follow Up</span>
                    </a>
                </div>
            </div>
            @endhasanyrole


            <?php  $visa_process_array = ['Admin',
            'Hiring-pool',
            'visa_cancel_request_hr',
               ]; ?>

     @hasanyrole($visa_process_array)
             <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="visa_cancel_req">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Visa Process Cancel</span>
                    </a>
                </div>
            </div>


            {{-- <div class="col-2 mb-2">
                <div class="card card-icon  bg_color_cls fc-corner-left border_cls">
                    <a href="javascript:void(0)"  class="card-body text-center p-2 text-white new_cls_process" id="visa_replace_req">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Visa Process Replacement</span>
                    </a>
                </div>
            </div> --}}
            @endhasanyrole
        </div>
    </div>


  <div class="row hide_cls process_div_cls mt-16" id="candidate_process_div" >

      <?php  $hiring_role_array_social = ['Admin','Hiring-pool','Hiring-add-career-social-media']; ?>

      @hasanyrole($hiring_role_array_social)
      <div class="col-2 mb-2">
          <div class="card card-icon  bg-success">
              <a href="{{ route('career_from_social_media') }}" target="_blank" class="card-body text-center p-2 text-white">
                  <i class="nav-icon i-Recycling-2 header-icon"></i>
                  <span class="item-name">Add Career Social Media</span>
              </a>
          </div>
      </div>
      @endhasanyrole


      <?php  $hiring_role_array_on_call = ['Admin','Hiring-pool','Hiring-add-candidate-on-call']; ?>

      @hasanyrole($hiring_role_array_on_call)
      <div class="col-2 mb-2">
          <div class="card card-icon  bg-success">
              <a href="{{ route('career_from_on_call') }}" target="_blank" class="card-body text-center p-2 text-white">
                  <i class="nav-icon i-Recycling-2 header-icon"></i>
                  <span class="item-name">Add Candidate On Call</span>
              </a>
          </div>
      </div>
      @endhasanyrole

      <?php  $hiring_role_array_on_international = ['Admin','Hiring-pool','Hiring-add-international-candidate']; ?>

      @hasanyrole($hiring_role_array_on_international)
      <div class="col-2 mb-2">
          <div class="card card-icon  bg-success">
              <a href="{{ route('career_from_international') }}" target="_blank" class="card-body text-center p-2 text-white">
                  <i class="nav-icon i-Recycling-2 header-icon"></i>
                  <span class="item-name">Add International Candidate</span>
              </a>
          </div>
      </div>
      @endhasanyrole

      <?php  $hiring_role_array_on_walk = ['Admin','Hiring-pool','Hiring-add-walkin-candidate']; ?>
      @hasanyrole($hiring_role_array_on_walk)
      <div class="col-2 mb-2">
          <div class="card card-icon  bg-success">
              <a href="{{ route('career_from_walk') }}" target="_blank" class="card-body text-center p-2 text-white">
                  <i class="nav-icon i-Recycling-2 header-icon"></i>
                  <span class="item-name">Add Walkin Candidate</span>
              </a>
          </div>
      </div>
      @endhasanyrole

          <?php  $hiring_role_array_on_walk = ['Admin','Hiring-pool','Hiring-Re-Entry','checkout_type_report']; ?>
          @hasanyrole($hiring_role_array_on_walk)
          <div class="col-2 mb-2">
              <div class="card card-icon  bg-success">
                  <a href="{{ route('checkout_type_report') }}" target="_blank" class="card-body text-center p-2 text-white">
                      <i class="nav-icon i-Recycling-2 header-icon"></i>
                      <span class="item-name">ReEntry Candidate</span>
                  </a>
              </div>
          </div>
          @endhasanyrole

          <?php  $hiring_role_array_agreed_ammount = ['Admin','Hiring-pool','AgreedAmount']; ?>

          @hasanyrole($hiring_role_array_agreed_ammount)
          <div class="col-2 mb-2">
              <div class="card card-icon  bg-success">
                  <a href="{{ route('agreed_amount.create') }}" target="_blank" class="card-body text-center p-2 text-white">
                      <i class="nav-icon i-Recycling-2 header-icon"></i>
                      <span class="item-name">Create Agreed Amount</span>
                  </a>
              </div>
          </div>
          @endhasanyrole

          <?php  $hiring_role_array_direct_checkout_report = ['Admin','Hiring-pool','Send-direct-to-checkout']; ?>

          @hasanyrole($hiring_role_array_direct_checkout_report)
          <div class="col-2 mb-2">
              <div class="card card-icon  bg-success">
                  <a href="{{ route('send_to_checkout_report') }}" target="_blank" class="card-body text-center p-2 text-white">
                      <i class="nav-icon i-Recycling-2 header-icon"></i>
                      <span class="item-name">Send Direct to checkout report</span>
                  </a>
              </div>
          </div>
          @endhasanyrole




  </div>




{{--    selection process--}}

    <div class="row hide_cls process_div_cls mt-16" id="selection_process_div" >

        <?php  $hiring_role_array_front = ['Admin','Hiring-pool','Hiring-front-desk']; ?>

        @hasanyrole($hiring_role_array_front)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('career_frontdesk') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Cursor-Select  header-icon"></i>
                    <span class="item-name">Front Desk</span>
                </a>
            </div>
        </div>
        @endhasanyrole


            <?php  $hiring_role_array_front = ['Admin','Hiring-pool','Hiring-front-desk']; ?>

            @hasanyrole($hiring_role_array_front)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('career_by_office.create') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Cursor-Select  header-icon"></i>
                        <span class="item-name">Update Candidate </span>
                    </a>
                </div>
            </div>
            @endhasanyrole


            <?php  $hiring_role_array_wait_list = ['Admin','Hiring-pool','Hiring-wait-list']; ?>
            @hasanyrole($hiring_role_array_wait_list)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('wait_list') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Cursor-Select  header-icon"></i>
                        <span class="item-name">Wait List</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $hiring_role_array_selected = ['Admin','Hiring-pool','Hiring-selected-candidate']; ?>
            @hasanyrole($hiring_role_array_selected)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('career_selected_candidate') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Cursor-Select  header-icon"></i>
                        <span class="item-name">Selected Candidate</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $hiring_role_array_selected = ['Admin','Hiring-pool','Rejection-report']; ?>
            @hasanyrole($hiring_role_array_selected)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('career_rejected') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Close-Window  header-icon"></i>
                        <span class="item-name">Rejected Candidate</span>
                    </a>
                </div>
            </div>
            @endhasanyrole


            <?php  $hiring_role_array_need_licence = ['Admin','Hiring-pool','Need_Licence']; ?>
            @hasanyrole($hiring_role_array_need_licence)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('need_to_take_licence') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Cursor-Select  header-icon"></i>
                        <span class="item-name">Need To Take Licence</span>
                    </a>
                </div>
            </div>
            @endhasanyrole


            <?php  $hiring_role_array_attachment = ['Admin','Hiring-pool','Missing_attachment_agreement']; ?>
            @hasanyrole($hiring_role_array_attachment)
            <div class="col-2 mb-2">
                <div class="card card-icon bg-success ">
                    <a href="{{ route('missing_agreed_amount')}}"  target="_blank"class="card-body text-center p-2 text-white" >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">Missing Attachment Agreed Amount</span>
                    </a>
                </div>
            </div>
            @endhasanyrole



    </div>


    {{--    interview process--}}

    <div class="row hide_cls process_div_cls mt-16" id="interview_process_div" >


        <?php  $hiring_role_array_interview_batch = ['Admin','Hiring-pool','Hiring-create-new-interview-batch']; ?>
        @hasanyrole($hiring_role_array_interview_batch)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('create_interview.index') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Business-Man  header-icon"></i>
                    <span class="item-name">Create new Interview Batch</span>
                </a>
            </div>
        </div>
        @endhasanyrole


            <?php  $hiring_role_array_interview_batch_report = ['Admin','Hiring-pool','Hiring-interview-btach-report']; ?>
            @hasanyrole($hiring_role_array_interview_batch_report)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('batch_report') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Business-Man header-icon"></i>
                        <span class="item-name">Interview Result/Update</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="referal_process_div" >


        <?php  $hiring_role_array_referal = ['Admin','Hiring-pool','Hiring-referal-rewards']; ?>
        @hasanyrole($hiring_role_array_referal)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('referal') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Business-Mens header-icon"></i>
                    <span class="item-name">Referral Rewards</span>
                </a>
            </div>
        </div>
        @endhasanyrole

    </div>

    <div class="row hide_cls process_div_cls mt-16" id="onboard_process_div" >

            <?php  $hiring_role_array_on_board = ['Admin','Hiring-pool','Hiring-onboard-report']; ?>
            @hasanyrole($hiring_role_array_on_board)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('onboard') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Board Report</span>
                    </a>
                </div>
            </div>
            @endhasanyrole


            <?php  $hiring_role_array_waiting_for_training = ['Admin','Hiring-pool','waiting_for_training']; ?>


            @hasanyrole($hiring_role_array_waiting_for_training)
            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('waiting_for_training') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Waiting For Training</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php $hiring_role_array_waiting_for_reservation = ['Admin','Hiring-pool','waiting_for_reservation']; ?>
                @hasanyrole($hiring_role_array_waiting_for_reservation)
                <div class="col-2 mb-2">
                    <div class="card card-icon  bg-success">
                        <a href="{{ route('waiting_for_reservation') }}" target="_blank" class="card-body text-center p-2 text-white">
                            <i class="nav-icon i-Checked-User header-icon"></i>
                            <span class="item-name">Waiting For Reservation</span>
                        </a>
                    </div>
                </div>
                @endhasanyrole



    </div>

    <div class="row hide_cls process_div_cls mt-16" id="career_followup_div" >

        <?php  $hiring_role_array_frontdesk_followup = ['Admin','Hiring-pool','Hiring-followup']; ?>
        @hasanyrole($hiring_role_array_frontdesk_followup)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('view_frontdesk_follow_up') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Checked-User header-icon"></i>
                    <span class="item-name">Front Desk Follow Up</span>
                </a>
            </div>
        </div>
        @endhasanyrole

        <?php  $hiring_role_array_waitlist_followup = ['Admin','Hiring-pool','Hiring-followup']; ?>
        @hasanyrole($hiring_role_array_waitlist_followup)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('view_waitlist_follow_up') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Checked-User header-icon"></i>
                    <span class="item-name">Wait List Follow Up</span>
                </a>
            </div>
        </div>
        @endhasanyrole

        <?php  $hiring_role_array_selected_followup = ['Admin','Hiring-pool','Hiring-followup']; ?>
        @hasanyrole($hiring_role_array_selected_followup)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('view_selected_follow_up') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Checked-User header-icon"></i>
                    <span class="item-name">Selected Follow Up</span>
                </a>
            </div>
        </div>
        @endhasanyrole

        <?php  $hiring_role_array_onboard_followup = ['Admin','Hiring-pool','Hiring-followup']; ?>
        @hasanyrole($hiring_role_array_onboard_followup)
        <div class="col-2 mb-2">
            <div class="card card-icon  bg-success">
                <a href="{{ route('view_onboard_follow_up') }}" target="_blank" class="card-body text-center p-2 text-white">
                    <i class="nav-icon i-Checked-User header-icon"></i>
                    <span class="item-name">OnBoard Follow Up</span>
                </a>
            </div>
        </div>
        @endhasanyrole



</div>


<div class="row hide_cls process_div_cls mt-16" id="visa_cancel_req_div" >

    <?php  $hiring_role_array_visa_cancel_request_hr = ['Admin','Hiring-pool','visa_cancel_request_hr']; ?>
    @hasanyrole($hiring_role_array_visa_cancel_request_hr)
    <div class="col-2 mb-2">
        <div class="card card-icon  bg-success">
            <a href="{{ url('visa_replacement_request_hr') }}" target="_blank" class="card-body text-center p-2 text-white">
                <i class="nav-icon i-Checked-User header-icon"></i>
                <span class="item-name">Visa Cancel Request</span>
            </a>
        </div>
    </div>
    @endhasanyrole



</div>





    <div class="submenu"  id="reports-menu-items">
        <div class="row">

            <?php  $hiring_role_array_career_report = ['Admin','Hiring-pool','career_report']; ?>
            @hasanyrole($hiring_role_array_career_report)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-primary fc-corner-left ">
                    <a href="{{ route('career_report')}}"  target="_blank" class="card-body text-center p-2 text-white " >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">Career Report</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $hiring_role_array_agreed_amount = ['Admin','Hiring-pool','AgreedAmount']; ?>
            @hasanyrole($hiring_role_array_agreed_amount)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-primary fc-corner-left ">
                    <a href="{{ route('agreed_amount.index')}}"  target="_blank" class="card-body text-center p-2 text-white " >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">View Agreed Amount</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $hiring_role_array_agreed_amount = ['Admin','Hiring-pool','reserved_report']; ?>
            @hasanyrole($hiring_role_array_agreed_amount)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-primary fc-corner-left ">
                    <a href="{{ route('reserved_report')}}"  target="_blank" class="card-body text-center p-2 text-white " >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">Reservation Report</span>
                    </a>
                </div>
            </div>
            @endhasanyrole

            <?php  $hiring_role_array_agreed_amount = ['Admin','Hiring-pool','Hiring-onboard-report']; ?>
            @hasanyrole($hiring_role_array_agreed_amount)

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-primary fc-corner-left ">
                    <a href="{{ route('dc_sent_request_checkin')}}"  target="_blank" class="card-body text-center p-2 text-white " >
                        <i class="nav-icon i-Recycling-2 header-icon"></i>
                        <span class="item-name">Checkin Request Sent Report</span>
                    </a>
                </div>
            </div>
            @endhasanyrole







        </div>
    </div>





@endsection

@section('js')
    <script>
        @if(request('active') != null)
        $("#{{request('active')}}" ).show(600);
            @endif
        var active_submenu = "";
        $('.main-menu').click(function(){
            var current_submenu = $(this).attr('data-child-menu-items');
            if(current_submenu !== active_submenu){
                $('.submenu').hide(600);
                $('#'+ current_submenu).show(600);
                active_submenu = current_submenu;

                $(".process_div_cls").hide();
                $(".new_cls_process").removeClass('active_cls');
            }
        });

        $(".new_cls_process").click(function () {
           var id = $(this).attr('id');
            var now_id = id+"_div";
            $(".process_div_cls").hide();
            $(".new_cls_process").removeClass('active_cls');
            $(this).addClass('active_cls');


            $("#"+now_id).show(600);
           $("#"+now_id).css("display","flex");


        });
    </script>
@endsection
