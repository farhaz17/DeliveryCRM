<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            @if(in_array(1, $user->user_group_id))
            <li class="nav-item" data-item="dashboard"><a class="nav-item-hold" href="{{route('dashboard')}}"><i class="nav-icon i-Dashboard"></i><span class="nav-text">Dashboard</span></a>
                <div class="triangle"></div>
            </li>
            @endif

                @if(!in_array(1, $user->user_group_id) && !in_array(15, $user->user_group_id) && !in_array(16, $user->user_group_id) && !in_array(17, $user->user_group_id) || ($user->designation_type=="1"))
                    <li class="nav-item"><a class="nav-item-hold" href="{{ url('dashboard-user')}}"><i class="nav-icon i-Dashboard"></i><span class="nav-text">Dashboard</span></a>
                        <div class="triangle"></div>
                    </li>
                @endif

                <?php  $cod_roll_array = ['Cod','Cod-except-close-month','Admin','Cod_only_cash']; ?>
                @hasanyrole($cod_roll_array)
                <li class="nav-item"><a class="nav-item-hold" href="{{ url('cod_dashboard')}}"><i class="nav-icon i-Dashboard"></i><span class="nav-text">Cod Dashboard</span></a>
                    <div class="triangle"></div>
                </li>
                 @endhasanyrole

                <?php  $master_roll_array = ['Master','Admin','master-normal']; ?>
                @hasanyrole($master_roll_array)
                <li class="nav-item" data-item="masters"><a class="nav-item-hold" href="#"><i class="nav-icon i-Bar-Chart"></i><span class="nav-text">Masters</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $user_management_roll_array = ['User-Management','Admin']; ?>
                @hasanyrole($user_management_roll_array)
                    <li class="nav-item" data-item="user_management"><a class="nav-item-hold" href="#"><i class="nav-icon i-Administrator"></i><span class="nav-text">User Management</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole



                <?php  $operation_roll_array = ['Operation','Admin','operation-teamlead','operation-manager','operation-normal']; ?>
                @hasanyrole($operation_roll_array)
                <li class="nav-item" data-item="operation"><a class="nav-item-hold" href="#"><i class="nav-icon i-Suitcase"></i><span class="nav-text">Operation</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $reports_roll_array = ['Reports','Admin','Ropert-except-admin-report']; ?>
                @hasanyrole($reports_roll_array)
                <li class="nav-item" data-item="reports"><a class="nav-item-hold" href="#"><i class="nav-icon i-Computer-Secure"></i><span class="nav-text">Reports</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $current_status_roll_array = ['Current-status','Admin']; ?>
                @hasanyrole($current_status_roll_array)
                <li class="nav-item" data-item="current_status"><a class="nav-item-hold" href="#"><i class="nav-icon i-Checked-User"></i><span class="nav-text">Current Status</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $category_assign_roll_array = ['Category-assign','Admin']; ?>
                @hasanyrole($category_assign_roll_array)

                <li class="nav-item" data-item="category_assigns"><a class="nav-item-hold" href="#"><i class="nav-icon i-Checked-User"></i><span class="nav-text">Category Assigns</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $unregistered_roll_array = ['Unregistered','Admin']; ?>
                @hasanyrole($unregistered_roll_array)
                <li class="nav-item" data-item="alerts"><a class="nav-item-hold" href="#"><i class="nav-icon i-Bell"></i><span class="nav-text">Unregistered</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $upload_forms_roll_array = ['Upload-forms','Admin']; ?>
                @hasanyrole($upload_forms_roll_array)
                <li class="nav-item" data-item="forms" ><a class="nav-item-hold" href="#"><i class="text-20 i-Upload"></i><span class="nav-text">Upload Forms</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $passport_roll_array = ['Passport','Admin']; ?>
                @hasanyrole($passport_roll_array)
                <li class="nav-item" data-item="passport" ><a class="nav-item-hold" href="#"><i class="nav-icon i-Library"></i><span class="nav-text">Passport</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $usercodes_roll_array = ['UserCodes','Admin']; ?>
                @hasanyrole($usercodes_roll_array)
                <li class="nav-item" data-item="usercodes" ><a class="nav-item-hold" href="#"><i class="nav-icon i-Library"></i><span class="nav-text">User Codes</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $agreement_roll_array = ['Agreement','Admin']; ?>
                @hasanyrole($agreement_roll_array)
                <li class="nav-item" data-item="agreement" ><a class="nav-item-hold" href="#"><i class="nav-icon i-File-Horizontal-Text"></i><span class="nav-text">Agreement</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $driving_license_roll_array = ['Driving-license','Admin']; ?>
                @hasanyrole($driving_license_roll_array)
                <li class="nav-item" data-item="driving_license_step" ><a class="nav-item-hold" href="#"><i class="nav-icon i-File-Horizontal-Text"></i><span class="nav-text">Driving License</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $onboard_roll_array = ['Onboard','Admin']; ?>
                @hasanyrole($onboard_roll_array)
                <li class="nav-item" data-item="on_board" ><a class="nav-item-hold" href="#"><i class="nav-icon i-File-Clipboard-Text--Image"></i><span class="nav-text">On Board</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole



                <?php  $hiringpoll_roll_array = ['Hiring-pool','Admin']; ?>
                @hasanyrole($hiringpoll_roll_array)
                <li class="nav-item" data-item="career" ><a class="nav-item-hold" href="#"><i class="nav-icon i-File-Clipboard-Text--Image"></i><span class="nav-text">Hiring Pool</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $verification_request_roll_array = ['Verification-request','Admin']; ?>
                @hasanyrole($verification_request_roll_array)
                <li class="nav-item" data-item="verification" ><a class="nav-item-hold" href="#"><i class="nav-icon i-File-Clipboard-Text--Image"></i><span class="nav-text">Verification Requests</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $assigment_request_roll_array = ['Assignment','assignment-office','assignment-normal','Assigment-view-only','Admin']; ?>
                @hasanyrole($assigment_request_roll_array)
                <li class="nav-item" data-item="assignments"><a class="nav-item-hold" href="#"><i class="nav-icon i-Add-User"></i><span class="nav-text">Assignments</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $compression_request_roll_array = ['Compression','Admin']; ?>
                @hasanyrole($compression_request_roll_array)
                <li class="nav-item" data-item="comparison" ><a class="nav-item-hold" href="#"><i class="text-20 i-Upload"></i><span class="nav-text">Comparison</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $notification_request_roll_array = ['Notification','Admin']; ?>
                @hasanyrole($notification_request_roll_array)
                <li class="nav-item" data-item="notification"><a class="nav-item-hold" href="#"><i class="nav-icon i-Bell"></i><span class="nav-text">Notification</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $users_request_roll_array = ['users','User-manage-rider','Admin']; ?>
                @hasanyrole($users_request_roll_array)
                <li class="nav-item" data-item="users"><a class="nav-item-hold" href="#"><i class="nav-icon i-Add-User"></i><span class="nav-text">Users</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $users_request_roll_array = ['Setting','Admin']; ?>
                @hasanyrole($users_request_roll_array)
                <li class="nav-item" data-item="setting"><a class="nav-item-hold" href="#"><i class="nav-icon i-Data-Settings"></i><span class="nav-text">Setting</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $add_emirates_roll_array = ['Emirates-id','Admin']; ?>
                @hasanyrole($add_emirates_roll_array)
                    <li class="nav-item" data-item="emirates_id"><a class="nav-item-hold" href="#"><i class="nav-icon i-ID-Card"></i><span class="nav-text">Add Emirates Id</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole




                    @hasanyrole($cod_roll_array)
                    <li class="nav-item" data-item="cods"><a class="nav-item-hold" href="#"><i class="nav-icon i-Financial"></i><span class="nav-text">Cod</span></a>
                        <div class="triangle"></div>
                    </li>
                   @endhasanyrole



                <?php  $performance_roll_array = ['Performance','Admin']; ?>
                @hasanyrole($performance_roll_array)
                    <li class="nav-item" data-item="performance"><a class="nav-item-hold" href="#"><i class="nav-icon i-Statistic"></i><span class="nav-text">Performance</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole


                <?php  $interview_roll_array = ['Interview','Admin']; ?>
                @hasanyrole($interview_roll_array)
                    <li class="nav-item" data-item="create_interview"><a class="nav-item-hold" href="#"><i class="nav-icon i-Add-UserStar"></i><span class="nav-text">Create Interview</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole





                <?php  $reserve_roll_array = ['Reserve','Admin']; ?>
                @hasanyrole($reserve_roll_array)
                    <li class="nav-item" data-item="reserved"><a class="nav-item-hold" href="#"><i class="nav-icon i-Add-UserStar"></i><span class="nav-text">Reserved</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole

                <?php  $profile_roll_array = ['Profile','Admin','profile-view-only']; ?>
                @hasanyrole($profile_roll_array)
                <li class="nav-item" data-item="profile"><a class="nav-item-hold" href="#"><i class="nav-icon i-Male-21"></i><span class="nav-text">Profile</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $visa_cancel_roll_array = ['Visa_cancel_pro','Visa_cancel_departments','Admin']; ?>
                @hasanyrole($visa_cancel_roll_array)
                <li class="nav-item" data-item="visa_cancel"><a class="nav-item-hold" href="#"><i class="nav-icon i-Close-Window"></i><span class="nav-text">Visa Cancellation</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole



                <?php  $arbalance_roll_array = ['Arbalance','Admin']; ?>
                @hasanyrole($arbalance_roll_array)
                <li class="nav-item" data-item="ar_balance"><a class="nav-item-hold" href="#"><i class="nav-icon i-Calculator-2"></i><span class="nav-text">A/R Balance</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


{{--                <li class="nav-item" data-item="data_entry"><a class="nav-item-hold" href="#"><i class="nav-icon i-Calculator-2"></i><span class="nav-text">Data Entry</span></a>--}}
{{--                    <div class="triangle"></div>--}}
{{--                </li>--}}

                <?php  $fine_upload_roll_array = ['Fine-upload','Admin']; ?>
                @hasanyrole($fine_upload_roll_array)
                    <li class="nav-item" data-item="fine_uploads"><a class="nav-item-hold" href="#"><i class="nav-icon i-upload"></i><span class="nav-text">Fine Uploads</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole


                <?php  $salik_uploads_roll_array = ['Salik-upload','Admin']; ?>
                @hasanyrole($salik_uploads_roll_array)
                    <li class="nav-item" data-item="salik_uploads"><a class="nav-item-hold" href="#"><i class="nav-icon i-upload"></i><span class="nav-text">Salik Uploads</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole


                <?php  $sim_bill_uploads_roll_array = ['Sim-bill-upload','Admin']; ?>
                @hasanyrole($sim_bill_uploads_roll_array)
                <li class="nav-item" data-item="sim_bill_uploads"><a class="nav-item-hold" href="#"><i class="nav-icon i-upload"></i><span class="nav-text">Sim Bill Uploads</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole

                <?php  $rider_fuel_roll_array = ['Rider-fuel','Admin']; ?>
                @hasanyrole($rider_fuel_roll_array)
                <li class="nav-item" data-item="rider_fuel"><a class="nav-item-hold" href="#"><i class="nav-icon i-Geo2-"></i><span class="nav-text">Rider Fuel</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole


                <?php  $rider_fuel_roll_array = ['Bike-ImpoundingUpload','Admin']; ?>
                @hasanyrole($rider_fuel_roll_array)
                <li class="nav-item" data-item="bike_impounding_upload"><a class="nav-item-hold" href="#"><i class="nav-icon i-Motorcycle"></i><span class="nav-text">Bike Impounding Upload</span></a>
                    <div class="triangle"></div>
                </li>
                @endhasanyrole




                <?php  $rider_order_roll_array = ['Rider-order','Admin']; ?>
                @hasanyrole($rider_order_roll_array)
                    <li class="nav-item" data-item="rider_orders"><a class="nav-item-hold" href="#"><i class="nav-icon i-Arrow-Circle"></i><span class="nav-text">Rider Orders</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole

                <?php  $attandance_roll_array = ['Attandance','Admin']; ?>
                @hasanyrole($attandance_roll_array)
                    <li class="nav-item" data-item="attendance"><a class="nav-item-hold" href="#"><i class="nav-icon i-Checked-User"></i><span class="nav-text">Attendance</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole

                <?php  $attandance_roll_array = ['Referral_rewards','Admin']; ?>
                @hasanyrole($attandance_roll_array)
                    <li class="nav-item" data-item="referrals"><a class="nav-item-hold" href="#"><i class="nav-icon i-Checked-User"></i><span class="nav-text">Referral Rewards</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole



                <?php  $bike_roll_array = ['Admin']; ?>
                @hasanyrole($bike_roll_array)
                    <li class="nav-item" data-item="bike_profile"><a class="nav-item-hold" href="#"><i class="nav-icon i-Checked-User"></i><span class="nav-text">Bike Profile</span></a>
                        <div class="triangle"></div>
                    </li>
                @endhasanyrole


            <?php  $salary_sheet_array = ['Salary_sheet_upload','Admin']; ?>
            @hasanyrole($salary_sheet_array)
            <li class="nav-item" data-item="salary_sheet"><a class="nav-item-hold" href="#"><i class="nav-icon i-Money-2"></i><span class="nav-text">Salary Sheet</span></a>
                <div class="triangle"></div>
            </li>
            @endhasanyrole


                @if($user->id == '1292')
                    <li class="nav-item" data-item="category_assign"><a class="nav-item-hold" href="#"><i class="nav-icon i-Checked-User"></i><span class="nav-text">Assign Status</span></a>
                        <div class="triangle"></div>
                    </li>
                @endif
















                {{--            @if(in_array(1, $user->user_group_id))--}}
{{--                <li class="nav-item" data-item="driving_license"><a class="nav-item-hold" href="#"><i class="nav-icon i-Add-Window"></i><span class="nav-text">Driving License</span></a>--}}
{{--                    <div class="triangle"></div>--}}
{{--                </li>--}}
{{--            @endif--}}


</ul>

    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Submenu Dashboards-->
        <ul class="childNav" data-parent="dashboard">
            <li class="nav-item"><a href="{{url('dashboard')}}"><i class="nav-icon i-Dashboard"></i><span class="item-name">Dashboard</span></a></li>
            @if(in_array(1, $user->user_group_id) )
            <li class="nav-item"><a href="{{url('admin-dashboard')}}"><i class="nav-icon i-Dashboard"></i><span class="item-name">Admin Dashboard</span></a></li>
                @endif
        </ul>

        @can('user-management')
        <ul class="childNav" data-parent="user_management">
                <li class="nav-item"><a href="{{ route('roles.index') }}"><i class="nav-icon i-Administrator"></i><span class="item-name">User Roles</span></a></li>
                <li class="nav-item"><a href="{{ route('permissions.index') }}"><i class="nav-icon i-Administrator"></i><span class="item-name">User Permissions</span></a></li>
        </ul>
        @endcan



        <ul class="childNav" data-parent="masters">

            <?php  $master_array_permission = ['master-bike-tracking-history','master-bike-tracking','master-bike-master','master-sim-master']; ?>
            <?php  $master_array_role = ['Master','Admin']; ?>
            <?php  $master_not_admin_array_role = ['master-normal']; ?>

            @hasanyrole($master_not_admin_array_role)
                    <li class="nav-item"><a href="{{url('sim_master')}}"><i class="nav-icon i-Memory-Card"></i><span class="item-name">SIM Master</span></a></li>
                    <li class="nav-item"><a href="{{url('bikes_master')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bikes Master</span></a></li>
                    <li class="nav-item"><a href="{{route('bike_tracking')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bikes Tracking</span></a></li>
                    <li class="nav-item"><a href="{{url('bike_tracking_history')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bikes Tracking History</span></a></li>
            @endhasanyrole

                @hasanyrole($master_array_role)

                <li class="nav-item"><a href="{{url('sim_master')}}"><i class="nav-icon i-Memory-Card"></i><span class="item-name">SIM Master</span></a></li>
                <li class="nav-item"><a href="{{url('bikes_master')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bikes Master</span></a></li>
                <li class="nav-item"><a href="{{route('bike_tracking')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bikes Tracking</span></a></li>
                <li class="nav-item"><a href="{{url('bike_tracking_history')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bikes Tracking History</span></a></li>

            <li class="nav-item"><a href="{{route('parts')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Parts</span></a></li>

            <li class="nav-item"><a href="{{route('mplatform')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Platform</span></a></li>
            <li class="nav-item"><a href="{{route('muser_group')}}"><i class="nav-icon i-Business-ManWoman"></i><span class="item-name">User roles</span></a></li>
            <li class="nav-item"><a href="{{route('missue_department')}}"><i class="nav-icon i-Door"></i><span class="item-name">Issue Department</span></a></li>
            <li class="nav-item"><a href="{{route('major_department')}}"><i class="nav-icon i-Home1"></i><span class="item-name">Major Department</span></a></li>
            <li class="nav-item"><a href="{{url('nationalities')}}"><i class="nav-icon i-Flag-2"></i><span class="item-name">Nationalities</span></a></li>
            <li class="nav-item"><a href="{{url('companies')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">Companies</span></a></li>
            <li class="nav-item"><a href="{{url('companies_info')}}"><i class="nav-icon i-Information"></i><span class="item-name">Companies Info</span></a></li>
            <li class="nav-item"><a href="{{url('designation')}}"><i class="nav-icon i-Men"></i><span class="item-name">Designation</span></a></li>
            <li class="nav-item"><a href="{{url('ppuid')}}"><i class="nav-icon i-Men"></i><span class="item-name">PPUIDS</span></a></li>
            <li class="nav-item"><a href="{{url('category_master')}}"><i class="nav-icon i-Tree-3"></i><span class="item-name">Master Category</span></a></li>
            <li class="nav-item"><a href="{{url('category_assign')}}"><i class="nav-icon i-Tree-3"></i><span class="item-name">Category Assign</span></a></li>
            <li class="nav-item"><a href="{{url('expiry')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Expiry</span></a></li>
            <li class="nav-item"><a href="{{url('performance_setting')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">General Settings</span></a></li>

                @endhasanyrole
        </ul>
        <ul class="childNav" data-parent="inventory">
            <li class="nav-item"><a href="{{route('inv_parts')}}"><i class="nav-icon i-File-Clipboard-Text--Image"></i><span class="item-name">Manage Parts</span></a></li>
        </ul>
        <ul class="childNav" data-parent="operation">

            @can('operation-manage-ticket')
                <li class="nav-item"><a href="{{route('ticket')}}"><i class="nav-icon i-Ticket"></i><span class="item-name">Manage Tickets</span></a></li>
            @endcan


                    @can('ticket-approve-tickets-manager')
                  <li class="nav-item"><a href="{{route('approve_tickets_manager')}}"><i class="nav-icon i-Flag-2"></i><span class="item-name">Approve Tickets as Manager</span></a></li>
                   @endcan

                @can('ticket-approve-tickets-teamlead')
                <li class="nav-item"><a href="{{route('approve_tickets_teamlead')}}"><i class="nav-icon i-Flag-2"></i><span class="item-name">Approve Tickets as Team Lead</span></a></li>
                @endcan

                @can('operation-approve-ticket')
                <li class="nav-item"><a href="{{route('approve_tickets')}}"><i class="nav-icon i-Post-Sign"></i><span class="item-name">Approve Tickets</span></a></li>
                @endcan

              @can('operation-shared-ticket')
                <li class="nav-item"><a href="{{url('ticket_share')}}"><i class="nav-icon i-Post-Sign"></i><span class="item-name">Shared Tickets</span></a></li>
               @endcan

        </ul>


        <ul class="childNav" data-parent="reports">
            @can('report-vehicle-report')
            <li class="nav-item"><a href="{{url('vehcile_report')}}">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="item-name">Vehicle Report</span></a>
            </li>
            @endcan
                @can('report-sim-report')
            <li class="nav-item">
                <a href="{{url('sim_report')}}">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="item-name">SIM Report</span></a>
            </li>
                @endcan
                @can('report-assign-report')
            <li class="nav-item">
                <a href="{{url('assign_report_admin')}}">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="item-name">Assign Report Admin</span>
                </a>
            </li>
                @endcan
                @can('report-assign-report-verify')
            <li class="nav-item">
                <a href="{{url('assign_report')}}">
                    <i class="nav-icon i-Receipt-4"></i>
                    <span class="item-name">Assign Report</span>
                </a>
            </li>
                @endcan


                @can('report-contractor_report')
                    <li class="nav-item"><a href="{{url('contractor_report')}}">
                            <i class="nav-icon i-Receipt-4"></i>
                            <span class="item-name">4PL Contractor Report</span></a>
                    </li>
                @endcan
        </ul>



        <ul class="childNav" data-parent="alerts">
            <li class="nav-item"><a href="{{route('manage_alerts')}}"><i class="nav-icon i-Arrow-Cross"></i><span class="item-name">Manage Alerts</span></a></li>
        </ul>
        <ul class="childNav" data-parent="current_status">
            @can('current-status')
            <li class="nav-item"><a href="{{url('category_master')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Current Status</span></a></li>
            @endcan
            <li class="nav-item"><a href="{{url('category_visa_status')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Visa Current Status</span></a></li>
            <li class="nav-item"><a href="{{url('active_inactive_category_status')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Acitve/In-Active Current Status</span></a></li>
            <li class="nav-item"><a href="{{url('working_category_status')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Working Current Status</span></a></li>
        </ul>
        <ul class="childNav" data-parent="category_assigns">
            @can('category_assign_category_assign')
            <li class="nav-item"><a href="{{url('category_assign')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Category Assings</span></a></li>
            @endcan

                @can('category_assign_visa_category_assign')
            <li class="nav-item"><a href="{{url('category_assign_visa')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Visa Category Assigns</span></a></li>
                @endcan
                @can('category_assign_active_inactive_category_assign')
            <li class="nav-item"><a href="{{url('category_assign_active')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Acitve/In-Active Category Assings</span></a></li>
            @endcan
                @can('category_assign_working_category_assign')
                    <li class="nav-item"><a href="{{url('category_assign_working')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Working Category Assigns</span></a></li>
                @endcan
        </ul>
        <ul class="childNav" data-parent="forms">
            @can('upload-form-upload-form')
            <li class="nav-item"><a href="{{route('upload_form')}}"><i class="text-20 i-Add-Window"></i><span class="item-name">Upload Forms</span></a></li>
            @endcan
            @can('upload-form-upload-category')
            <li class="nav-item"><a href="{{route('upload_category')}}"><i class="text-20 i-Add-Window"></i><span class="item-name">Upload Category</span></a></li>
            @endcan
            @can('upload-form-view-forms')
            <li class="nav-item"><a href="{{route('view_form')}}"><i class="text-20 i-Duplicate-Window"></i><span class="item-name">View Forms</span></a></li>
            @endcan

        </ul>

<ul class="childNav" data-parent="stars">
<li class="nav-item"><a href="{{route('work_permit')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Work Permit</span></a></li>
<li class="nav-item"><a href="{{route('e_visa')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">E-Visa</span></a></li>
<li class="nav-item"><a href="{{route('change_status')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Change Status</span></a></li>
<li class="nav-item"><a href="{{route('medical_info')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Medical Information</span></a></li>
<li class="nav-item"><a href="{{route('labour_approval')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Labour Approval</span></a></li>
<li class="nav-item"><a href="{{route('residence_visa')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Residense Visa</span></a></li>
<li class="nav-item"><a href="{{route('eid_reg')}}"><i class="nav-icon i-Over-Time"></i><span class="item-name">Emirates ID</span></a></li>

<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">Driving License</span></a></li>
<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">RTA Permit</span></a></li>
<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">Plateform</span></a></li>
<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">Insurance</span></a></li>
<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">COD</span></a></li>
<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">Telecomminication</span></a></li>
<li class="nav-item"><a href="#"><i class="nav-icon i-Over-Time"></i><span class="item-name">Occupational Master</span></a></li>
</ul>

<ul class="childNav" data-parent="passport">
    @can('passport-passport-create')
            <li class="nav-item"><a href="{{route('passport')}}"><i class="nav-icon i-Book"></i><span class="item-name">Passport</span></a></li>
    @endcan
        @can('passport-passport-view')
            <li class="nav-item"><a href="{{route('view_passport')}}"><i class="nav-icon i-Full-View-Window"></i><span class="item-name">View Passport</span></a></li>
        @endcan
        @can('passport-passport-visa-process')
            <li class="nav-item"><a href="{{route('star')}}"><i class="nav-icon i-Visa"></i><span class="item-name">Visa Process</span></a></li>
        @endcan
        @can('passport-passport-history')
            <li class="nav-item"><a href="{{url('passport_history')}}"><i class="nav-icon i-File-Search"></i><span class="item-name">Passport History</span></a></li>
        @endcan

        @can('passport-passport-ppuid_cancel')
            <li class="nav-item"><a href="{{url('ppuid_cancel')}}"><i class="nav-icon i-File-Search"></i><span class="item-name">Passport History</span></a></li>
        @endcan

</ul>


<ul class="childNav" data-parent="usercodes">
    @can('usercodes')
    <li class="nav-item"><a href="{{route('usercodes')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">User Codes</span></a></li>
    @endcan
</ul>

<ul class="childNav" data-parent="agreement">
    @can('agreement-agreement-view')
<li class="nav-item"><a href="{{route('agreement')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Agreements</span></a></li>
    @endcan
        @can('agreement-agreement-create')
<li class="nav-item"><a href="{{route('agreement.create')}}"><i class="nav-icon i-Receipt-4"></i><span class="item-name">Create Agreement</span></a></li>
        @endif
        @can('agreement-driving-license-amount')
<li class="nav-item"><a href="{{route('driving_license_amount')}}"><i class="nav-icon i-Duplicate-Layer"></i><span class="item-name">Driving License Amount</span></a></li>
        @endif
        @can('agreement-agreement-fees-amount')
<li class="nav-item"><a href="{{route('agreement_amount_fees')}}"><i class="nav-icon i-Duplicate-Layer"></i><span class="item-name">Agreement Amount Fees</span></a></li>
        @endif
        @can('agreement-agreement-discount-name')
<li class="nav-item"><a href="{{route('discount_name')}}"><i class="nav-icon i-Duplicate-Layer"></i><span class="item-name">Discount Name</span></a></li>
        @endif
        @can('agreement-agreement-admin-amount')
<li class="nav-item"><a href="{{route('admin_fee')}}"><i class="nav-icon i-Dollar"></i><span class="item-name">Admin Amount</span></a></li>
        @endif
</ul>

<ul class="childNav" data-parent="passport_handler_status">
<li class="nav-item"><a href="{{route('passport_handler.create')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Passport Handler Status</span></a></li>
</ul>

<ul class="childNav" data-parent="driving_license_step">
    @can('driving-license')
<li class="nav-item"><a href="{{route('driving_license')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Create License</span></a></li>
    @endcan
</ul>

<ul class="childNav" data-parent="on_board">
    @can('onboard-view')
<li class="nav-item"><a href="{{route('onboard')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">On Boards</span></a></li>
    @endcan
@can('onboard-accident-vacation')
<li class="nav-item"><a href="{{route('vacation_accident_rider')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Rider Accident/Vacation</span></a></li>
@endcan
</ul>

<ul class="childNav" data-parent="career">
    @can('hiring-pool-pending')
<li class="nav-item"><a href="{{route('career')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Pending</span></a></li>
    @endcan
{{--<li class="nav-item"><a href="{{route('career_shortlisted')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Short Listed</span></a></li>--}}
        @can('hiring-pool-rejected')
<li class="nav-item"><a href="{{route('career_rejected')}}"><i class="nav-icon i-Close-Window"></i><span class="item-name">Rejected</span></a></li>
        @endcan
        @can('hiring-pool-document-pending')
<li class="nav-item"><a href="{{route('career_document_pending')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Document Pending</span></a></li>
        @endcan
{{--<li class="nav-item"><a href="{{route('career_hired')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Selected</span></a></li>--}}
{{--<li class="nav-item"><a href="{{route('career_wait_list')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Wait List</span></a></li>--}}

</ul>

<ul class="childNav" data-parent="verification">
{{--<li class="nav-item "  ><a href="{{route('verification')}}"><i class="nav-icon i-Receipt-3"></i><span class="item-name">Verification</span></a></li>--}}
    @can('verification-request-passport-report')
    <li class="nav-item"><a href="{{route('passport_report')}}"><i class="nav-icon i-Full-View-Window"></i><span class="item-name">Passport Report</span></a></li>
    @endcan

{{--            <li class="nav-item"><a href="{{route('verification_assignment')}}"><i class="nav-icon i-Full-View-Window"></i><span class="item-name">Verification Assign</span></a></li>--}}
{{--            <li class="nav-item"><a href="{{route('total_sim_verified')}}"><i class="nav-icon i-Memory-Card-2"></i><span class="item-name">Total Verified Sim</span></a></li>--}}
{{--            <li class="nav-item"><a href="{{route('total_bike_verified')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Total Verified Bike</span></a></li>--}}
{{--            <li class="nav-item"><a href="{{route('total_Platform_verified')}}"><i class="nav-icon i-Firewall"></i><span class="item-name">Total Verified PlatForm</span></a></li>--}}
</ul>

<ul class="childNav" data-parent="users">
    @can('user-manage-user')
<li class="nav-item"><a href="{{route('manage_user')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Manage User</span></a></li>
    @endcan
        @can('user-manage-riders')
<li class="nav-item"><a href="{{route('rider_profile')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Manage Riders</span></a></li>
        @endcan
</ul>
<ul class="childNav" data-parent="assignments">

  @can('assignment-sim-assignment')
    <li class="nav-item"><a href="{{route('assign')}}"><i class="i-Memory-Card-3"></i><span class="item-name">&nbsp;&nbsp; SIM Assignment</span></a></li>
    @endcan

      @can('assignment-bike-assignment')
        <li class="nav-item"><a href="{{url('assign_bike')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bike Assignment</span></a></li>
      @endcan
{{--        <li class="nav-item"><a href="{{route('assign')}}"><i class="i-Memory-Card-3"></i><span class="item-name">&nbsp;&nbsp; SIM Assignment</span></a></li>--}}
      @can('assignment-platform-assignment')
        <li class="nav-item"><a href="{{url('assign_plateform')}}"><i class="nav-icon i-One-Window"></i><span class="item-name">Platform Assignment</span></a></li>
      @endcan

      @can('assignment-platform-assignment')
          <li class="nav-item"><a href="{{url('platform_checkout')}}"><i class="nav-icon i-One-Window"></i><span class="item-name">Platform checkout</span></a></li>
      @endcan

      @can('assignment-office-sim-assignment')
        <li class="nav-item"><a href="{{url('office_sim_assign')}}"><i class="nav-icon i-Memory-Card-2"></i><span class="item-name">Office SIM Assignment</span></a></li>
      @endcan

      @can('assignment-assign-dashboard')
        <li class="nav-item"><a href="{{url('assign_dashboard')}}"><i class="nav-icon i-Memory-Card-2"></i><span class="item-name">Assign Dashboard</span></a></li>
      @endcan





      @unlessrole('Admin')
      @can('assignment-bike-assignment-view')
          <li class="nav-item"><a href="{{url('assign_bike')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Bike Assignment</span></a></li>
      @endcan

      @can('assignment-sim-assignment-view')
          <li class="nav-item"><a href="{{route('assign')}}"><i class="i-Memory-Card-3"></i><span class="item-name">&nbsp;&nbsp; SIM Assignment</span></a></li>
      @endcan

      @can('assignment-platform-assignment-view')
          <li class="nav-item"><a href="{{url('assign_plateform')}}"><i class="nav-icon i-One-Window"></i><span class="item-name">Platform Assignment</span></a></li>
      @endcan

      @endunlessrole




</ul>



<ul class="childNav" data-parent="comparison">
@can('compression-labour-compression')
<li class="nav-item"><a href="{{ route('labour_upload') }}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Labour Comparison</span></a></li>
 @endcan

@can('compression-bike-compression')
<li class="nav-item"><a href="{{route('bike_upload')}}"><i class="nav-icon i-Bicycle"></i><span class="item-name">Bike Comparison</span></a></li>
  @endcan
    @can('compression-sim-compression')
<li class="nav-item"><a href="{{route('sim_upload')}}"><i class="nav-icon i-Memory-Card-3"></i><span class="item-name">SIM Comparison</span></a></li>
    @endcan
    @can('compression-labour-existing')
<li class="nav-item"><a href="{{url('labour_exist')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Labour Existing</span></a></li>
    @endcan
</ul>

<ul class="childNav" data-parent="setting">
    @can('setting-department-info')
<li class="nav-item"><a href="{{route('department_contact')}}"><i class="nav-icon i-Information"></i><span class="item-name">Deparment Contact Info</span></a></li>
    @endcan
</ul>
<ul class="childNav" data-parent="notification">
    @can('notification-platform-notification')
<li class="nav-item"><a href="{{route('plateform_notification')}}"><i class="nav-icon i-Bell"></i><span class="item-name">Platform Notification</span></a></li>
    @endcan
</ul>

<ul class="childNav" data-parent="driving_license">
<li class="nav-item"><a href="{{route('driving_license')}}"><i class="nav-icon i-Duplicate-Window"></i><span class="item-name">Driving License</span></a></li>
</ul>

<ul class="childNav" data-parent="emirates_id">
    @can('add-emirates-id')
<li class="nav-item"><a href="{{route('emirates_id_card')}}"><i class="nav-icon i-ID-Card"></i><span class="item-name">Emirates Id</span></a></li>
    @endcan
</ul>



{{--<ul class="childNav" data-parent="cod">--}}
{{--<li class="nav-item"><a href="{{route('cash_receive')}}"><i class="nav-icon i-Financial"></i><span class="item-name">Cash on Delivery</span></a></li>--}}
{{--</ul>--}}



            @hasanyrole($cod_roll_array)
        <ul class="childNav" data-parent="cods">
            @can('cod-dashboard')
                <li class="nav-item"><a href="{{route('cod_dashboard')}}"><i class="nav-icon i-Financial"></i><span class="item-name">Dashboard</span></a></li>
            @endcan

            @can('cod-cash-request')
                <li class="nav-item"><a href="{{route('cods')}}"><i class="nav-icon i-Financial"></i><span class="item-name">Cash Requests</span></a></li>
            @endcan

            @can('cod-bank-request')
                <li class="nav-item"><a href="{{route('cod_bank')}}"><i class="nav-icon i-University1"></i><span class="item-name">Bank Requests</span></a></li>
            @endcan

            @can('cod-cash-request')
                <li class="nav-item"><a href="{{route('add_cod_cash_request')}}"><i class="nav-icon i-Dollar"></i><span class="item-name">Add Cash COD</span></a></li>
            @endcan



            @can('cod-bank-issue-request')
             <li class="nav-item"><a href="{{route('cod_bank_issue')}}"><i class="nav-icon i-University1"></i><span class="item-name">Bank Issue Requests</span></a></li>
            @endcan

            @can('cod-rider-cod')
                    <li class="nav-item"><a href="{{route('rider_cod')}}"><i class="nav-icon i-Motorcycle"></i><span class="item-name">Rider Cod</span></a></li>
            @endcan

            @can('cod-adjustment-request')
                    <li class="nav-item"><a href="{{route('cod_adjust')}}"><i class="nav-icon i-Data-Settings"></i><span class="item-name">Cod Adjustment Request</span></a></li>
            @endcan

            @can('cod-add-bank-cod')
                <li class="nav-item"><a href="{{route('add_cod_bank_request')}}"><i class="nav-icon i-Data-Settings"></i><span class="item-name">Add Bank COD</span></a></li>
            @endcan

            @can('cod-upload')
                    <li class="nav-item"><a href="{{route('cod_uploads')}}"><i class="nav-icon i-Upload"></i><span class="item-name">Cod Upload</span></a></li>
            @endcan

            @can('cod-missing-rider')
                    <li class="nav-item"><a href="{{route('missing_rider_id')}}"><i class="nav-icon i-Find-User"></i><span class="item-name">Missing Rider Id</span></a></li>
            @endcan

            @can('cod-uploaded-data')
                    <li class="nav-item"><a href="{{route('uploaded_data')}}"><i class="nav-icon i-Upload-Window"></i><span class="item-name">Uploaded Data</span></a></li>
            @endcan

            @can('cod-close-month')
                <li class="nav-item"><a href="{{route('cod_close_month')}}"><i class="nav-icon i-Upload-Window"></i><span class="item-name">Close the Month</span></a></li>
            @endcan
        </ul>
            @endhasanyrole


        <ul class="childNav" data-parent="performance">

            @can('performance-upload-performance')
            <li class="nav-item"><a href="{{route('performance')}}"><i class="nav-icon i-Upload"></i><span class="item-name">Upload Performance</span></a></li>
            @endcan
            @can('performance-view-performance')
            <li class="nav-item"><a href="{{url('view_performance')}}"><i class="nav-icon i-Full-View-Window"></i><span class="item-name">View Performance</span></a></li>
            @endcan
            @can('performance-two-weeks-rating')
            <li class="nav-item"><a href="{{url('two_weeks')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Two Weeks Ratings</span></a></li>
            @endcan
            @can('performance-over-all-rating')
            <li class="nav-item"><a href="{{url('all_rating')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Over All Ratings Ratings</span></a></li>
            @endcan
            @can('performance-performance-setting')
            <li class="nav-item"><a href="{{url('performance_setting')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Performance Settings</span></a></li>
            @endcan
        </ul>



        <ul class="childNav" data-parent="create_interview">
            @can('interview-create-interview')
            <li class="nav-item"><a href="{{route('create_interview')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Create Interview</span></a></li>
            @endcan
            @can('interview-sent-invitation')
            <li class="nav-item"><a href="{{route('sent_interview')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">All Sent Invitation</span></a></li>
            @endcan

            @can('interview-acknowledge-invitation')
            <li class="nav-item"><a href="{{route('acknowledge_interview')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">Acknowledge Invitation</span></a></li>
            @endcan

            @can('interview-rejected-invitation')
            <li class="nav-item"><a href="{{route('invitation_rejected')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">Rejected Invitation</span></a></li>
            @endcan

            @can('interview-pass-candidate')
            <li class="nav-item"><a href="{{route('pass_candidate')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">Pass Candidate</span></a></li>
            @endcan

            @can('interview-fail-candidate')
            <li class="nav-item"><a href="{{route('fail_candidate')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">Fail Candidate</span></a></li>
            @endcan

            @can('interview-recent-interview')
            <li class="nav-item"><a href="{{route('recent_interview')}}"><i class="nav-icon i-Business-Mens"></i><span class="item-name">Recent Interview</span></a></li>
            @endcan
            @can('interview-batch-interview')
            <li class="nav-item"><a href="{{route('batch_report')}}"><i class="nav-icon i-Repeat2"></i><span class="item-name">Batch Report</span></a></li>
             @endcan
        </ul>



        <ul class="childNav" data-parent="reserved">
            @can('reserve-reserve-bike')
            <li class="nav-item"><a href="{{route('reserve_bike')}}"><i class="nav-icon i-Add-UserStar"></i><span class="item-name">Reserve Bike</span></a></li>
            @endcan
        </ul>


        <ul class="childNav" data-parent="profile">
            @can('profile-view-profile')
            <li class="nav-item"><a href="{{route('profile.index')}}"><i class="nav-icon i-Male-21"></i><span class="item-name">View Profile</span></a></li>
            @endcan
        </ul>

        <ul class="childNav" data-parent="visa_cancel">
            @can('visa_cancel_visa_cancel')
            <li class="nav-item"><a href="{{url('visa_cancel')}}"><i class="nav-icon i-Male-21"></i><span class="item-name">Visa Cancel</span></a></li>
            @endcan

            @can('visa_cancel_view_visa_clearance_report')
            <li class="nav-item"><a href="{{url('view_clearance_report')}}"><i class="nav-icon i-Close-Window"></i><span class="item-name">Cancel Clearance Report</span></a></li>
            @endcan

            @can('visa_cancel_approve_cancel_visa_request_pro')
            <li class="nav-item"><a href="{{url('cancal_approve')}}"><i class="nav-icon i-Checked-User"></i><span class="item-name">Visa Cancel Approval</span></a></li>
            @endcan

            @can('visa_cancel_visa_clearance_requests')
             <li class="nav-item"><a href="{{url('view_clear_requests')}}"><i class="nav-icon i-Close-Window"></i><span class="item-name">Visa Cancel Requests</span></a></li>
            @endcan

            @can('visa_cancel_all_cancelled_visa')
            <li class="nav-item"><a href="{{url('cancal_show')}}"><i class="nav-icon i-Block-Window"></i><span class="item-name">Cancelled Visas</span></a></li>
            @endcan

        </ul>

        <ul class="childNav" data-parent="ar_balance">

            @can('arbalance-arbalance')
            <li class="nav-item"><a href="{{url('ar_balance')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">A/R Balance</span></a></li>
            @endcan
            @can('arbalance-addition-dedication-balance')
            <li class="nav-item"><a href="{{url('ar_balance_sheet')}}"><i class="nav-icon i-Coins"></i><span class="item-name">Addition & Deduction Balance</span></a></li>
            @endcan
            @can('arbalance-arbalance-report')
            <li class="nav-item"><a href="{{url('ar_balance_report')}}"><i class="nav-icon i-Computer-Secure"></i><span class="item-name">A/R Balance Report</span></a></li>
            @endcan

        </ul>


{{--        <ul class="childNav" data-parent="data_entry">--}}
{{--                <li class="nav-item"><a href="{{url('assign')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">SIM Assignment</span></a></li>--}}
{{--                <li class="nav-item"><a href="{{url('assign_bike')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">Bike Assignment</span></a></li>--}}
{{--                <li class="nav-item"><a href="{{url('assign_plateform')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">Platform Assignment</span></a></li>--}}
{{--                <li class="nav-item"><a href="{{url('emirates_id_card')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">Emirates ID</span></a></li>--}}
{{--                <li class="nav-item"><a href="{{url('driving_license')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">Driving Licence</span></a></li>--}}
{{--                <li class="nav-item"><a href="{{url('view_passport')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">Passport Details</span></a></li>--}}
{{--                <li class="nav-item"><a href="{{url('assign_report')}}"><i class="nav-icon i-Calculator-2"></i><span class="item-name">Assignment Report</span></a></li>--}}
{{--        </ul>--}}

        <ul class="childNav" data-parent="fine_uploads">
            @can('fine-upload-upload-fine-sheet')
            <li class="nav-item"><a href="{{route('fine_uploads.create')}}"><i class="nav-icon i-Upload"></i><span class="item-name">Upload Fine Sheet</span></a></li>
            @endcan
            @can('fine-upload-uploaded-data')
            <li class="nav-item"><a href="{{route('fine_uploads')}}"><i class="nav-icon i-Upload-Window"></i><span class="item-name">Uploaded Data</span></a></li>
            @endcan

            @can('fine-upload-rider-fines')
            <li class="nav-item"><a href="{{route('rider_fines')}}"><i class="nav-icon i-Upload-Window"></i><span class="item-name">Rider Fines</span></a></li>
             @endcan

        </ul>

        <ul class="childNav" data-parent="salik_uploads">
            @can('salik-upload-upload-salik-sheet')
                <li class="nav-item"><a href="{{route('salik_uploads.create')}}"><i class="nav-icon i-Upload"></i><span class="item-name">Upload Salik Sheet</span></a></li>
            @endcan
            @can('salik-upload-uploaded-data')
                <li class="nav-item"><a href="{{route('salik_uploads')}}"><i class="nav-icon i-Upload-Window"></i><span class="item-name">Uploaded Data</span></a></li>
            @endcan

        </ul>

        <ul class="childNav"  data-parent="rider_orders">
            @can('rider-order-all-order')
            <li class="nav-item"><a href="{{route('rider_orders')}}"><i class="nav-icon i-Arrow-Circle"></i><span class="item-name">All Rider Order</span></a></li>
            @endcan
            @can('rider-order-add-rider-order')
            <li class="nav-item"><a href="{{route('add_order_rates')}}"><i class="nav-icon i-Add-Window"></i><span class="item-name">Add Rider Order Rates</span></a></li>
            @endcan
        </ul>

        <ul class="childNav"  data-parent="attendance">
            @can('attandance-rider-attandance')
            <li class="nav-item"><a href="{{route('rider_attendance')}}"><i class="nav-icon i-Add-Window"></i><span class="item-name">Rider Attendance</span></a></li>
            @endcan
        </ul>


        {{-- <ul class="childNav"  data-parent="category_assign">
            @if($user->id == '1292')
            <li class="nav-item"><a href="{{url('category_assign')}}"><i class="nav-icon i-Add-Window"></i><span class="item-name">Current Status</span></a></li>
                @endif

        </ul> --}}
        <ul class="childNav"  data-parent="referrals">
            @can('refferal')
                <li class="nav-item"><a href="{{route('referal')}}"><i class="nav-icon i-Add-Window"></i><span class="item-name">Referrals</span></a></li>
            @endcan
        </ul>

        <ul class="childNav"  data-parent="bike_profile">
            @can('admin')
                <li class="nav-item"><a href="{{route('bike_profile')}}"><i class="nav-icon i-Add-Window"></i><span class="item-name">Referrals</span></a></li>
            @endcan
        </ul>
        <ul class="childNav"  data-parent="salary_sheet">
            @can('salary_sheet')
                <li class="nav-item"><a href="{{route('salary_sheet')}}"><i class="nav-icon i-Money-2"></i><span class="item-name">Salary Sheet</span></a></li>
            @endcan
        </ul>

        <ul class="childNav"  data-parent="sim_bill_uploads">
            @can('sim-bill-upload-list')
                <li class="nav-item"><a href="{{route('sim_bill_upload.create')}}"><i class="nav-icon i-Money-2"></i><span class="item-name">Upload Sim Bill</span></a></li>
                <li class="nav-item"><a href="{{route('sim_bill_upload')}}"><i class="nav-icon i-Money-2"></i><span class="item-name">Uploaded Data</span></a></li>
            @endcan
        </ul>

        <ul class="childNav"  data-parent="rider_fuel">
            @can('admin')
                <li class="nav-item"><a href="{{route('rider_fuel')}}"><i class="nav-icon i-Money-2"></i><span class="item-name">Rider Fuel</span></a></li>
            @endcan
        </ul>

        <ul class="childNav"  data-parent="bike_impounding_upload">
            @can('bike_impounding')
                <li class="nav-item"><a href="{{route('bike_impounding.create')}}"><i class="nav-icon i-Upload"></i><span class="item-name">Upload Bike Impounding</span></a></li>
                <li class="nav-item"><a href="{{route('bike_impounding')}}"><i class="nav-icon i-Data-Center"></i><span class="item-name">Uploaded Data</span></a></li>
            @endcan
        </ul>















</div>
<div class="sidebar-overlay"></div>
</div>
