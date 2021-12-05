@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        table.table.table-striped.table-dark.dataTable.no-footer{
            font-size: 12px;
        }
        img#userDropdown.user_avatar{
            width: 15em !important;
        }
        .menu-items-custom{
            padding: 3px;
        }
        .card-body.text-center {
            padding: .8em;
        }
        .menu-icon-grid.dashboard-sub-menu{

        }
        .menu-icon-grid.dashboard-sub-menu a {
            padding: 5px !important;
        }
        .dashboard-sub-menu a{
            width: 100% !important;
            margin-bottom: 5px;
        }
        .dashboard-sub-menu a:last-child{
            margin-bottom: 0px;
        }
        .dashboard-sub-menu a:first-child{
            margin-top: 3px;
        }
        .image-upload>input {
            display: none;
        }
        .bd-highlight {
            background-color: rgb(230 230 230);
            border: 1px solid rgba(86,61,124,0.15);
        }
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        </style>
@endsection
@section('content')
    <div class="row">
        <div class="card h-100 col-md-12">
            <form action="" method="">
                <div class="row justify-content-center">
                    <div class="form-group text-center m-3" style="width: 600px;">
                        <label for="repair_category">Search Menu</label><br>
                        <div class="input-group ">
                            <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                            <input class="form-control typeahead menu-search" autofocus="true" id="keyword" autocomplete="off" type="text" name="search_value" placeholder="Search..." aria-label="Username" required aria-describedby="basic-addon1">
                            <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                            <div id="clear">
                                X
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div class="ul-widget__body mt-0">
                    <div class="ul-widget1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="row">
                                    <?php  $dashboard_roll_array = ['Admin','Admin-user']; ?>
                                    @hasanyrole($dashboard_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonDashboard" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonDashboard" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @if(!in_array(1, $user->user_group_id) && !in_array(15, $user->user_group_id) && !in_array(16, $user->user_group_id) && !in_array(17, $user->user_group_id) || ($user->designation_type=="1"))
                                                                <a href="{{ url('dashboard-user')}}" onclick="window.location.assign(this.href)" class="border border-dark">Dashboard</a>
                                                            @endif
                                                            @can('dashboard-user')
                                                                {{-- <a href="{{ url('dashboard-user')}}" onclick="window.location.assign(this.href)" class="border border-dark"> Dashboard</a> --}}
                                                            @endcan
                                                            @if(in_array(1, $user->user_group_id) )
                                                                <a href="{{url('admin-dashboard')}}" onclick="window.location.assign(this.href)" class="border border-dark">Admin Dashboard</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Dashboard</p>
                                            </div>
                                        </div>
                                    </div>
                                   @endhasanyrole
                                   <?php  $user_management_roll_array = ['User-Management','Admin']; ?>
                                   @hasanyrole($user_management_roll_array)
                                   <div class="col-md-2 menu-items-custom">
                                       <div class="card card-icon mb-1">
                                           <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                               <div class="dropdown" >
                                                   <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonDashboard" ></i>
                                                   <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonDashboard" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                       <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                           @can('user-management')
                                                               <a href="{{ route('roles.index') }}" onclick="window.location.assign(this.href)" class="border border-dark">User Roles</a>
                                                               <a href="{{ route('permissions.index') }}" onclick="window.location.assign(this.href)" class="border border-dark">User Permissions</a>
                                                           @endcan
                                                       </div>
                                                   </div>
                                               </div>
                                               <p class="text-muted mt-2 mb-2">User Management</p>
                                           </div>
                                       </div>
                                   </div>
                                  @endhasanyrole
                                   <?php  $cod_roll_array = ['Cod','Cod-except-close-month','Admin','Cod_only_cash']; ?>
                                   @hasanyrole($cod_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonCODDashboard" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCODDashboard" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            <a class="nav-item-hold border border-dark" href="{{ url('cod_dashboard')}}" class="border border-dark">Cod Dashboard</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">COD Dashboard</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                    <?php  $master_array_permission = ['master-bike-tracking-history','master-bike-tracking','master-bike-master','master-sim-master']; ?>
                                    <?php  $master_array_role = ['Master','Admin','master-normal']; ?>
                                    <?php  $master_not_admin_array_role = ['master-normal']; ?>

                                    @hasanyrole($master_array_role)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Bar-Chart header-icon" role="button" id="dropdownMenuButtonMasters" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonMasters" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                            <?php  $master_array_permission = ['master-bike-tracking-history','master-bike-tracking','master-bike-master','master-sim-master','4_PL']; ?>
                                                            <?php  $master_array_role = ['Master','Admin']; ?>
                                                            <?php  $master_not_admin_array_role = ['master-normal']; ?>
                                                            <?php  $master_not_admin_4_pl = ['4_pl_master']; ?>

                                                            @hasanyrole($master_not_admin_array_role)
                                                            <a href="{{url('sim_master')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Sim Master</a>
                                                            <a href="{{url('bikes_master')}} " onclick="window.location.assign(this.href)" class="border border-dark">Bikes Master</a>
                                                            <a href="{{route('bike_tracking')}} " onclick="window.location.assign(this.href)" class="border border-dark">Bikes Tracking</a>
                                                            <a href="{{url('bike_tracking_history')}} " onclick="window.location.assign(this.href)" class="border border-dark">Bikes Tracking History</a>

                                                            @endhasanyrole
                                                            @hasanyrole($master_not_admin_4_pl)
                                                            <a href="{{url('four_pl')}} " onclick="window.location.assign(this.href)" class="border border-dark">4 PL Master</a>

                                                            @endhasanyrole

                                                            @hasanyrole($master_array_role)

                                                            <a href="{{url('sim_master')}}" onclick="window.location.assign(this.href)" class="border border-dark">SIM Master</a>
                                                            <a href="{{url('bikes_master')}}" onclick="window.location.assign(this.href)" class="border border-dark">Bikes Master</a>
                                                            <a href="{{route('bike_tracking')}}" onclick="window.location.assign(this.href)" class="border border-dark">Bikes Tracking</a>
                                                            <a href="{{url('bike_tracking_history')}}" onclick="window.location.assign(this.href)" class="border border-dark">Bikes Tracking History</a>
                                                            <a href="{{url('four_pl')}} " onclick="window.location.assign(this.href)" class="border border-dark">4 PL Master</a>
                                                            <a href="{{ route('parts')}} " onclick="window.location.assign(this.href)" class="border border-dark">Parts</a>
                                                            <a href="{{ route('mplatform')}} " onclick="window.location.assign(this.href)" class="border border-dark">Platform</a>
                                                            <a href="{{ route('muser_group')}} " onclick="window.location.assign(this.href)" class="border border-dark">User roles</a>
                                                            <a href="{{ route('missue_department')}} " onclick="window.location.assign(this.href)" class="border border-dark">Issue Department</a>
                                                            <a href="{{ route('major_department')}} " onclick="window.location.assign(this.href)" class="border border-dark">Major Department</a>
                                                            <a href="{{ url('nationalities')}} " onclick="window.location.assign(this.href)" class="border border-dark">Nationalities</a>
                                                            <a href="{{ url('companies')}} " onclick="window.location.assign(this.href)" class="border border-dark">Companies</a>
                                                            <a href="{{ url('companies_info')}} " onclick="window.location.assign(this.href)" class="border border-dark">Companies Info</a>
                                                            <a href="{{ url('designation')}} " onclick="window.location.assign(this.href)" class="border border-dark">Designation</a>
                                                            <a href="{{ url('ppuid')}} " onclick="window.location.assign(this.href)" class="border border-dark">PPUIDS</a>
                                                            <a href="{{ url('category_master')}} " onclick="window.location.assign(this.href)" class="border border-dark">Master Category</a>
                                                            @can('Employee Position Manage')
                                                            <a href="{{ url('category_assign')}} " onclick="window.location.assign(this.href)" class="border border-dark">Category Assign</a>
                                                            @endcan
                                                            <a href="{{ url('expiry')}} " onclick="window.location.assign(this.href)" class="border border-dark">Expiry</a>
                                                            <a href="{{ url('performance_setting')}} " onclick="window.location.assign(this.href)" class="border border-dark">General Settings</a>

                                                            @endhasanyrole
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Masters</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $operation_roll_array = ['Operation','Admin','operation-teamlead','operation-manager','operation-normal']; ?>
                                    @hasanyrole($operation_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Suitcase header-icon" role="button" id="dropdownMenuButtonOperation" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonOperation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('operation-manage-ticket')
                                                                <a href="{{route('ticket')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Manage Tickets</a>
                                                            @endcan
                                                            @can('ticket-approve-tickets-manager')
                                                                <a href="{{route('approve_tickets_manager')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Approve Tickets as Manager</a>
                                                            @endcan
                                                            @can('ticket-approve-tickets-teamlead')
                                                                <a href="{{route('approve_tickets_teamlead')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Approve Tickets as Team Lead</a>
                                                            @endcan
                                                            @can('operation-approve-ticket')
                                                                <a href="{{route('approve_tickets')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Approve Tickets</a>
                                                            @endcan
                                                            @can('operation-shared-ticket')
                                                                <a href="{{url('ticket_share')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Shared Tickets</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Operation</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $reports_roll_array = ['Reports','Admin','Ropert-except-admin-report','Rider-report-roll','Temporary-bike-to-collect-roll','Temporary-sim-to-collect-roll','Four_pl_report']; ?>
                                    @hasanyrole($reports_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Computer-Secure header-icon" role="button" id="dropdownMenuButtonReport" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonReport" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('report-vehicle-report')
                                                            <a href="{{url('vehcile_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Vehicle Report</a>
                                                            @endcan
                                                            @can('report-sim-report')
                                                            <a href="{{url('sim_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">SIM Report</a>
                                                            @endcan
                                                            @can('report-assign-report')
                                                            <a href="{{url('assign_report_admin')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign Report Admin</a>
                                                            @endcan
                                                            @can('report-assign-report')
                                                            <a href="{{url('rider_no_platform')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Don't Have Platform </a>
                                                            @endcan



                                                            @can('report-assign-report-verify')
                                                            <a href="{{url('assign_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign ReportAssign Report</a>
                                                            @endcan
                                                            @can('rider-report')
                                                                  <a href="{{url('rider_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Report</a>
                                                            @endcan
                                                            @can('temporary_bike_to_collect')
                                                                <a href="{{url('temporary_bike_to_collect')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Temporary Bike To Collect Report</a>
                                                            @endcan
                                                            @can('temporary_bike_to_collect_history')
                                                                <a href="{{url('temporary_bike_to_collect_history')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Temporary Bike To Collect History</a>
                                                            @endcan
                                                            @can('temporary_sim_to_collect')
                                                                <a href="{{url('temporary_sim_to_collect')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Temporary Sim To Collect Report</a>
                                                            @endcan



                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Reports</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $current_status_roll_array = ['Current-status','Admin']; ?>
                                    @hasanyrole($current_status_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Add-User header-icon" role="button" id="dropdownMenuButtonCurrentStatus" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCurrentStatus" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('current-status')
                                                                <a href="{{url('category_master')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Current Status</a>
                                                            @endcan
                                                            <a href="{{url('category_visa_status')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Visa Current Status</a>

                                                            <a href="{{url('active_inactive_category_status')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Acitve/In-Active Current Status</a>

                                                            <a href="{{url('working_category_status')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Working Current Status</a>

                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Current Status</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $category_assign_roll_array = ['Category-assign','Admin','Employee Position Manager']; ?>
                                    @hasanyrole($category_assign_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Add-User header-icon" role="button" id="dropdownMenuButtonCategoryAssign" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCategoryAssign" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('Employee Position Manage')
                                                            <a href="{{url('category_assign')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Category Assings</a>
                                                            @endcan
                                                            @can('category_assign_visa_category_assign')
                                                            <a href="{{url('category_assign_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Visa Category Assigns</a>
                                                            @endcan
                                                            @can('category_assign_active_inactive_category_assign')
                                                            <a href="{{url('category_assign_active')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Acitve/In-Active Category Assings</a>
                                                            @endcan
                                                            @can('category_assign_working_category_assign')
                                                            <a href="{{url('category_assign_working')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Working Category Assigns</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Category Assigns</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                    <?php  $unregistered_roll_array = ['Unregistered','Admin']; ?>
                                    @hasanyrole($unregistered_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Add-User header-icon" role="button" id="dropdownMenuButtonUnregistered" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonUnregistered" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            <a href="{{route('manage_alerts')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Manage Alerts</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Unregistered</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $upload_forms_roll_array = ['Upload-forms','Admin']; ?>
                                    @hasanyrole($upload_forms_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Upload header-icon" role="button" id="dropdownMenuButtonUploadForms" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonUploadForms" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('upload-form-upload-form')
                                                                <a href="{{route('upload_form')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Upload Forms</a>
                                                            @endcan
                                                            @can('upload-form-upload-category')
                                                                <a href="{{route('upload_category')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Upload Category</a>
                                                            @endcan
                                                            @can('upload-form-view-forms')
                                                                <a href="{{route('view_form')}}" onclick="window.location.assign(this.href)" class="border border-dark" >View Forms</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Upload Forms</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    {{-- <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Upload header-icon" role="button" id="dropdownMenuButtonUploadForms" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonUploadForms" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                <a href="{{route('work_permit')}}" onclick="window.location.assign(this.href)" class="border border-dark">Work Permit</a>
                                                                <a href="{{route('e_visa')}}" onclick="window.location.assign(this.href)" class="border border-dark" >E-Visa</a>
                                                                <a href="{{route('change_status')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Change Status</a>
                                                                <a href="{{route('medical_info')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Medical Information</a>
                                                                <a href="{{route('labour_approval')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Labour Approval</a>
                                                                <a href="{{route('residence_visa')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Residense Visa</a>
                                                                <a href="{{route('eid_reg')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Emirates ID</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >Driving License</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >RTA Permit</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >Plateform</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >Insurance</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >COD</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >Telecomminication</a>
                                                                <a href="#" onclick="window.location.assign(this.href)" class="border border-dark" >Occupational Master</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Upload Forms</p>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <?php  $passport_roll_array = ['Passport','Admin']; ?>
                                    @hasanyrole($passport_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Library header-icon" role="button" id="dropdownMenuButtonPassport" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonPassport" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('passport-passport-create')
                                                                <a href="{{route('passport')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Passport</a>
                                                            @endcan
                                                            @can('passport-passport-view')
                                                                <a href="{{route('view_passport')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >View Passport</a>
                                                            @endcan
                                                            {{-- @can('passport-passport-visa-process')
                                                                <a href="{{route('star')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Visa Process</a>
                                                            @endcan --}}

                                                                @can('passport-passport-visa-process_report')
                                                                    <a href="{{route('visa_process_report_show')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Visa Process Report</a>
                                                                @endcan
                                                            @can('passport-passport-history')
                                                                <a href="{{url('passport_history')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Passport History</a>
                                                            @endcan

                                                            @can('passport-passport-create')
                                                                <a href="{{route('rider_dont_have_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Rider Don't have Visa Status</a>
                                                            @endcan


                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Passport</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $usercodes_roll_array = ['UserCodes','Admin']; ?>
                                    @hasanyrole($usercodes_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Library header-icon" role="button" id="dropdownMenuButtonUserCodes" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonUserCodes" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('usercodes')
                                                            <a href="{{route('usercodes')}}"   onclick="window.location.assign(this.href)" class="border border-dark">User Codes</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">User Codes</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $agreement_roll_array = ['Agreement','Admin']; ?>
                                    @hasanyrole($agreement_roll_array)
{{--                                    <div class="col-md-2 menu-items-custom">--}}
{{--                                        <div class="card card-icon mb-1">--}}
{{--                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                <div class="dropdown" >--}}
{{--                                                    <i class="i-Library header-icon" role="button" id="dropdownMenuButtonAgreement" ></i>--}}
{{--                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAgreement" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">--}}
{{--                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">--}}
{{--                                                            @can('agreement-agreement-view')--}}
{{--                                                            <a href="{{route('agreement')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >View Agreements</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('agreement-agreement-create')--}}
{{--                                                            <a href="{{route('agreement.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Create Agreement</a>--}}
{{--                                                            @endif--}}
{{--                                                            @can('agreement-driving-license-amount')--}}
{{--                                                            <a href="{{route('driving_license_amount')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Driving License Amount</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('agreement-agreement-fees-amount')--}}
{{--                                                            <a href="{{route('agreement_amount_fees')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Agreement Amount Fees</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('agreement-agreement-discount-name')--}}
{{--                                                            <a href="{{route('discount_name')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Discount Name</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('agreement-agreement-admin-amount')--}}
{{--                                                            <a href="{{route('admin_fee')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Admin Amount</a>--}}
{{--                                                            @endcan--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <p class="text-muted mt-2 mb-2">Agreement</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    @endhasanyrole
                                    <?php  $driving_license_roll_array = ['Driving-license','Admin']; ?>
                                    @hasanyrole($driving_license_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown">
                                                    <i class="i-File-Horizontal-Text header-icon" role="button" id="dropdownMenuButtonDrivingLicense" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonDrivingLicense" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('driving-license')
                                                                <a href="{{route('driving_license.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Create License</a>
                                                                <a href="{{route('driving_license')}}"   onclick="window.location.assign(this.href)" class="border border-dark">View License</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Driving License</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $onboard_roll_array = ['Onboard','Admin']; ?>
                                    @hasanyrole($onboard_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown">
                                                    <i class="i-File-Clipboard-Text--Image header-icon" role="button" id="dropdownMenuButtonOnBoard" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonOnBoard" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('onboard-view')
                                                                <a href="{{route('onboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">On Boards</a>
                                                            @endcan
                                                            @can('onboard-accident-vacation')
                                                                <a href="{{route('vacation_accident_rider')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Accident/Vacation</a>
                                                            @endcan
                                                                @can('onboard-view')
                                                                    <a href="{{route('waiting_for_training')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Waiting For Training</a>
                                                                @endcan

                                                                @can('onboard-view')
                                                                    <a href="{{route('waiting_for_reservation')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Waiting For Reservation</a>
                                                                @endcan

                                                                @can('onboard-view')
                                                                    <a href="{{route('reserved_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Reservation Report</a>
                                                                @endcan





                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">On Board</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                    <?php  $hiringpoll_roll_array = ['Hiring-pool','Admin']; ?>
                                    @hasanyrole($hiringpoll_roll_array)
{{--                                    <div class="col-md-2 menu-items-custom">--}}
{{--                                        <div class="card card-icon mb-1">--}}
{{--                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                <div class="dropdown">--}}
{{--                                                    <i class="i-File-Clipboard-Text--Image header-icon" role="button" id="dropdownMenuButtonHiringPool" ></i>--}}
{{--                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonHiringPool" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">--}}
{{--                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">--}}
{{--                                                            @can('hiring-pool-pending')--}}
{{--                                                                <a href="{{route('career')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('hiring-pool-rejected')--}}
{{--                                                                <a href="{{route('career_rejected')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rejected</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('hiring-pool-document-pending')--}}
{{--                                                                <a href="{{route('career_document_pending')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Document Pending</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('hiring-pool-document-pending')--}}
{{--                                                                <a href="{{route('only_new_visa_noc')}}"   onclick="window.location.assign(this.href)" class="border border-dark">New Visa/Freelance</a>--}}
{{--                                                            @endcan--}}
{{--                                                            @can('hiring-pool-document-pending')--}}
{{--                                                                <a href="{{route('not_new_visa_noc')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Not New Visa/Freelance</a>--}}
{{--                                                            @endcan--}}



{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <p class="text-muted mt-2 mb-2">Hiring Pool</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    @endhasanyrole

                                    <?php  $verification_request_roll_array = ['Verification-request','Admin']; ?>
                                    @hasanyrole($verification_request_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown">
                                                    <i class="i-File-Clipboard-Text--Image header-icon" role="button" id="dropdownMenuButtonVerificationRequests" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVerificationRequests" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('verification-request-passport-report')
                                                                <a href="{{route('passport_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Passport Report</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Verification Requests</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $assigment_request_roll_array = ['Assignment','assignment-office','assignment-normal','Assigment-view-only','Admin']; ?>
                                    @hasanyrole($assigment_request_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown">
                                                    <i class="i-File-Clipboard-Text--Image header-icon" role="button" id="dropdownMenuButtonAssignments" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAssignments" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('assignment-sim-assignment')
                                                                <a href="{{route('assign')}}"   onclick="window.location.assign(this.href)" class="border border-dark">SIM Assignment</a>
                                                            @endcan
                                                            @can('assignment-platform-assignment')
                                                                <a href="{{url('assign_bike')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike Assignment</a>
                                                            @endcan
                                                            @can('assignment-platform-assignment')
                                                                <a href="{{url('assign_plateform')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Platform Assignment</a>
                                                            @endcan
                                                            @can('assignment-office-sim-assignment')
                                                                <a href="{{url('office_sim_assign')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Office SIM Assignment</a>
                                                            @endcan
                                                            @can('assignment-assign-dashboard')
                                                                <a href="{{url('assign_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign Dashboard</a>
                                                            @endcan

                                                                @can('assignment-assign-dashboard')
                                                                    <a href="{{url('bike_replacement/create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike Replacement</a>
                                                                @endcan

                                                                @can('assignment-assign-dashboard')
                                                                    <a href="{{url('sim_replacement/create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">SIM Replacement</a>
                                                                @endcan

                                                                @can('assignment-assign-dashboard')
                                                                <a href="{{url('cancel_sim')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Make Sim Cancel</a>
                                                            @endcan

                                                            @can('assignment-assign-dashboard')
                                                                <a href="{{url('all_cancel_sim')}}"   onclick="window.location.assign(this.href)" class="border border-dark">All Cancel Sim</a>
                                                            @endcan

                                                            @unlessrole('Admin')
                                                                @can('assignment-bike-assignment-view')
                                                                    <a href="{{url('assign_bike')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike Assignment</a>
                                                                @endcan

                                                                @can('assignment-sim-assignment-view')
                                                                    <a href="{{route('assign')}}" onclick="window.location.assign(this.href)" class="border border-dark">SIM Assignment</a>
                                                                @endcan

                                                                @can('assignment-platform-assignment-view')
                                                                    <a href="{{url('assign_plateform')}}" onclick="window.location.assign(this.href)" class="border border-dark">Platform Assignment</a>
                                                                @endcan

                                                                @can('assignment-assign-dashboard')
                                                                    <a href="{{url('bike_replacement/create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike Replacement</a>
                                                                @endcan

                                                                @can('assignment-assign-dashboard')
                                                                    <a href="{{url('sim_replacement/create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">SIM Replacement</a>
                                                                @endcan



                                                            @endunlessrole
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Assignments</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $compression_request_roll_array = ['Compression','Admin']; ?>
                                    @hasanyrole($compression_request_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown">
                                                    <i class="i-File-Clipboard-Text--Image header-icon" role="button" id="dropdownMenuButtonComparison" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonComparison" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('compression-labour-compression')
                                                                <a href="{{ route('labour_upload') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Labour Comparison</a>
                                                            @endcan
                                                            @can('compression-bike-compression')
                                                                <a href="{{route('bike_upload')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike Comparison</a>
                                                            @endcan
                                                            @can('compression-sim-compression')
                                                                <a href="{{route('sim_upload')}}"   onclick="window.location.assign(this.href)" class="border border-dark">SIM Comparison</a>
                                                            @endcan
                                                            @can('compression-labour-existing')
                                                                <a href="{{url('labour_exist')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Labour Existing</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Comparison</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $notification_request_roll_array = ['Notification','Admin']; ?>
                                    @hasanyrole($notification_request_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown">
                                                    <i class="i-Bell header-icon" role="button" id="dropdownMenuButtonNotification" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonNotification" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('notification-platform-notification')
                                                                <a href="{{route('plateform_notification')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Platform Notification</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Notification</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $users_request_roll_array = ['users','User-manage-rider','Admin']; ?>
                                    @hasanyrole($users_request_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonUsers" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonUsers" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('user-manage-user')
                                                                <a href="{{route('manage_user')}}" onclick="window.location.assign(this.href)" class="border border-dark">Manage User</a>
                                                            @endcan
                                                            @can('user-manage-riders')
                                                                <a href="{{route('rider_profile')}}" onclick="window.location.assign(this.href)" class="border border-dark">Manage Riders</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Users</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $users_request_roll_array = ['Setting','Admin']; ?>
                                    @hasanyrole($users_request_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Data-Settings header-icon" role="button" id="dropdownMenuButtonSetting" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSetting" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('setting-department-info')
                                                                <a href="{{route('department_contact')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Deparment Contact Info</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Setting</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $add_emirates_roll_array = ['Emirates-id','Admin']; ?>
                                    @hasanyrole($add_emirates_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Data-Settings header-icon" role="button" id="dropdownMenuButtonSetting" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSetting" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('add-emirates-id')
                                                                <a href="{{route('emirates_id_card')}}"   onclick="window.location.assign(this.href)" class="border border-dark">View Emirates Id</a>
                                                                <a href="{{route('emirates_id_card.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Emirates Id</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Add Emirates Id</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $cod_roll_array = ['Admin','Cod','Cod-except-close-month','Cod_only_cash']; ?>
                                    @hasanyrole($cod_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonCod" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCod" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                            @can('cod-dashboard')
                                                                <a href="{{ url('cod_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Dashboard</a>
                                                            @endcan
                                                            @can('cod-cash-request')
                                                                <a href="{{route('cods')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Cash Requests</a>
                                                            @endcan
                                                            @can('cod-bank-request')
                                                                <a href="{{route('cod_bank')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Bank Requests</a>
                                                            @endcan
                                                            @can('cod-cash-request')
                                                                <a href="{{route('add_cod_cash_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Add Cash COD</a>
                                                            @endcan
                                                            @can('cod-bank-issue-request')
                                                                <a href="{{route('cod_bank_issue')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Bank Issue Requests</a>
                                                            @endcan
                                                            @can('cod-rider-cod')
                                                                <a href="{{route('rider_cod')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Rider Cod</a>
                                                            @endcan
                                                            @can('cod-adjustment-request')
                                                                <a href="{{route('cod_adjust')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Cod Adjustment Request</a>
                                                            @endcan
                                                            @can('add-cod-adjustment')
                                                                <a href="{{route('add_cod_adjust')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Add Cod Adjustment</a>
                                                            @endcan
                                                            @can('cod-add-bank-cod')
                                                                <a href="{{route('add_cod_bank_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Add Bank COD</a>
                                                            @endcan
                                                            @can('cod-upload')
                                                                <a href="{{route('cod_uploads')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Cod Upload</a>
                                                            @endcan
                                                            @can('cod-uploaded-data')
                                                                <a href="{{route('uploaded_data')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Uploaded Data</a>
                                                            @endcan
                                                            @can('balance-cod')
                                                                <a href="{{route('view_balance_cod')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Balance COD</a>
                                                            @endcan
                                                            @can('cod-close-month')
                                                                <a href="{{route('cod_close_month')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Close the Month</a>
                                                            @endcan
                                                            @can('cod-close-month-report')
                                                                <a href="{{route('close_month_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Close Month Report</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Cod</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                    <?php  $performance_roll_array = ['Performance','Admin']; ?>
                                    @hasanyrole($performance_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonPerformance" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonPerformance" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('performance-upload-performance')
                                                                <a href="{{route('performance')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Upload Performance</a>
                                                            @endcan
                                                            @can('performance-view-performance')
                                                                <a href="{{url('view_performance')}}"   onclick="window.location.assign(this.href)" class="border border-dark">View Performance</a>
                                                            @endcan
                                                            @can('performance-two-weeks-rating')
                                                                <a href="{{url('two_weeks')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Two Weeks Ratings</a>
                                                            @endcan
                                                            @can('performance-over-all-rating')
                                                                <a href="{{url('all_rating')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Over All Ratings Ratings</a>
                                                            @endcan
                                                            @can('performance-performance-setting')
                                                                <a href="{{url('performance_setting')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Performance Settings</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Performance</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $interview_roll_array = ['Interview','Admin']; ?>
                                    @hasanyrole($interview_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Add-UserStar header-icon" role="button" id="dropdownMenuButtonCreateInterview" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonCreateInterview" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('interview-create-interview')
                                                                <a href="{{route('create_interview.index')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Create Interview</a>
                                                            @endcan
                                                            @can('interview-sent-invitation')
                                                                <a href="{{route('sent_interview')}}"   onclick="window.location.assign(this.href)" class="border border-dark">All Sent Invitation</a>
                                                            @endcan
                                                            @can('interview-acknowledge-invitation')
                                                                <a href="{{route('acknowledge_interview')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Acknowledge Invitation</a>
                                                            @endcan
                                                            @can('interview-rejected-invitation')
                                                                <a href="{{route('invitation_rejected')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rejected Invitation</a>
                                                            @endcan
                                                            @can('interview-pass-candidate')
                                                                <a href="{{route('pass_candidate')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pass Candidate</a>
                                                            @endcan
                                                            @can('interview-fail-candidate')
                                                                <a href="{{route('fail_candidate')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Fail Candidate</a>
                                                            @endcan
                                                            @can('interview-recent-interview')
                                                                <a href="{{route('recent_interview')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Recent Interview</a>
                                                            @endcan
                                                            @can('interview-batch-interview')
                                                                <a href="{{route('batch_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Batch Report</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Create Interview</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $reserve_roll_array = ['Reserve','Admin']; ?>
                                    @hasanyrole($reserve_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Add-UserStar header-icon" role="button" id="dropdownMenuButtonReserveBike" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonReserveBike" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('reserve-reserve-bike')
                                                                <a href="{{route('reserve_bike')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Reserve Bike</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Reserved</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $profile_roll_array = ['Profile','Admin','profile-view-only']; ?>
                                    @hasanyrole($profile_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Male-21 header-icon" role="button" id="dropdownMenuButtonViewProfile" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonViewProfile" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('profile-view-profile')
                                                                <a href="{{route('profile.index')}}" onclick="window.location.assign(this.href)" class="border border-dark">View Profile</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Profile</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                    <?php  $arbalance_roll_array = ['Arbalance','Admin']; ?>
                                    @hasanyrole($arbalance_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Calculator-2 header-icon" role="button" id="dropdownMenuButtonA/RBalance" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonA/RBalance" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('arbalance-arbalance')
                                                                <a href="{{url('ar_balance')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >A/R Balance</a>
                                                            @endcan
                                                            @can('arbalance-addition-dedication-balance')
                                                                <a href="{{url('ar_balance_sheet')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >Addition &amp; Deduction Balance</a>
                                                            @endcan
                                                            @can('arbalance-arbalance-report')
                                                                <a href="{{url('ar_balance_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >A/R Balance Report</a>
                                                            @endcan
                                                                @can('arbalance-arbalance-history')
                                                                <a href="{{url('ar_balance_history')}}"   onclick="window.location.assign(this.href)" class="border border-dark" >A/R Balance History</a>
                                                            @endcan




                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">A/R Balance</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $fine_upload_roll_array = ['Fine-upload','Admin']; ?>
                                    @hasanyrole($fine_upload_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-upload header-icon" role="button" id="dropdownMenuButtonFineUploads" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonFineUploads" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('fine-upload-upload-fine-sheet')
                                                                <a href="{{route('fine_uploads.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Upload Fine Sheet</a>
                                                            @endcan
                                                            @can('fine-upload-uploaded-data')
                                                                <a href="{{route('fine_uploads')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Uploaded Data</a>
                                                            @endcan
                                                            @can('fine-upload-rider-fines')
                                                                <a href="{{route('rider_fines')}}" onclick="window.location.assign(this.href)" class="border border-dark">Rider Fines</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Fine Uploads</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $salik_uploads_roll_array = ['Salik-upload','Admin']; ?>
                                    @hasanyrole($salik_uploads_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-upload header-icon" role="button" id="dropdownMenuButtonFineUploads" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonFineUploads" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('salik-upload-upload-salik-sheet')
                                                                <a href="{{route('salik_uploads.create')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Upload Salik Sheet</a>
                                                            @endcan
                                                            @can('salik-upload-uploaded-data')
                                                                <a href="{{route('salik_uploads')}}" onclick="window.location.assign(this.href)" class="border border-dark" >Uploaded Data</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Salik Uploads</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $sim_bill_uploads_roll_array = ['Sim-bill-upload','Admin']; ?>
                                    @hasanyrole($sim_bill_uploads_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-upload header-icon" role="button" id="dropdownMenuButtonSimBillUploads" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSimBillUploads" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('sim-bill-upload-list')
                                                                <a href="{{route('sim_bill_upload.create')}}" onclick="window.location.assign(this.href)" class="border border-dark">Upload Sim Bill</a>
                                                                <a href="{{route('sim_bill_upload')}}" onclick="window.location.assign(this.href)" class="border border-dark">Uploaded Data</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Sim Bill Uploads</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $rider_fuel_roll_array = ['Rider-fuel','Admin','Rider-Fuel-Complete']; ?>
                                        @hasanyrole($rider_fuel_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Geo2- header-icon" role="button" id="dropdownMenuButtonRiderFuel" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonRiderFuel" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @hasanyrole($rider_fuel_roll_array)
                                                                <a href="{{route('rider_fuel')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Fuel</a>
                                                            @endhasanyrole
                                                                 @can('rider-fuel-platform')
                                                            <a href="{{ url('fuel_platform') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Current Platform For Fuel</a>
                                                                 @endcan
                                                                 @can('rider-fuel-platform-add')
                                                                <a href="{{route('fuel_platform.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Platform For Fuel</a>
                                                                 @endcan

                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Rider Fuel</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $rider_fuel_roll_array = ['Bike-ImpoundingUpload','Admin']; ?>
                                    @hasanyrole($rider_fuel_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Motorcycle header-icon" role="button" id="dropdownMenuButtonBikeImpoundingUpload" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonBikeImpoundingUpload" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('bike_impounding')
                                                                <a href="{{route('bike_impounding.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Upload Bike Impounding</a>
                                                                <a href="{{route('bike_impounding')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Uploaded Data</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Bike Impounding Upload</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $rider_order_roll_array = ['Rider-order','Admin']; ?>
                                    @hasanyrole($rider_order_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Arrow-Circle header-icon" role="button" id="dropdownMenuButtonRiderOrders" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonRiderOrders" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('rider-order-all-order')
                                                                <a href="{{route('rider_orders')}}"   onclick="window.location.assign(this.href)" class="border border-dark">All Rider Order</a>
                                                            @endcan

                                                            @can('rider-order-all-order')
                                                                <a href="{{route('unassigned_order')}}"   onclick="window.location.assign(this.href)" class="border border-dark">All Unassigned Order</a>
                                                            @endcan



                                                            @can('rider-order-add-rider-order')
                                                                <a href="{{route('add_order_rates')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Rider Order Rates</a>
                                                            @endcan
                                                            @can('add-rider-order')
                                                                    <a href="{{route('add_order')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Rider Order</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Rider Orders</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                    <?php  $attandance_roll_array = ['Attandance','Admin']; ?>
                                    @hasanyrole($attandance_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Checked-User header-icon" role="button" id="dropdownMenuButtonAttendance" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAttendance" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('attandance-rider-attandance')
                                                               <a href="{{route('rider_attendance')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Attendance</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Attendance</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $attandance_roll_array = ['Referral_rewards','Admin']; ?>
                                    @hasanyrole($attandance_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Checked-User header-icon" role="button" id="dropdownMenuButtonReferralRewards" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonReferralRewards" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('refferal')
                                                                <a href="{{route('referal')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Referrals</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Referral Rewards</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $bike_roll_array = ['Admin']; ?>
                                    @hasanyrole($bike_roll_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Checked-User header-icon" role="button" id="dropdownMenuButtonBikeProfile" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonBikeProfile" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('admin')
                                                                <a href="{{route('bike_profile')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Referrals</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Bike Profile</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole
                                    <?php  $salary_sheet_array = ['Salary_sheet_upload','Admin']; ?>
                                    @hasanyrole($salary_sheet_array)
                                    <div class="col-md-2 menu-items-custom">
                                        <div class="card card-icon mb-1">
                                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="dropdown" >
                                                    <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                            @can('salary_sheet')
                                                                <a href="{{route('salary_sheet')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Salary Sheet</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-muted mt-2 mb-2">Salary Sheet</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endhasanyrole

                                        <?php  $vis_application_array = ['Visa_application','Admin']; ?>
                                        @hasanyrole($vis_application_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('visa_applicaton_visa_application')
                                                                    <a href="{{route('visa_application')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Application</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Visa Application</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $passport_role_array = ['Passport_handler','Passport_collect_role','Incoming_passport_transfer_role','Collected_passport_report_role','Request_passport_role','Requested_passport_role','Outgoing_passport_transfer_role','Remove_from_locker_role','Not_returned_passport_role','Admin']; ?>
                                        @hasanyrole($passport_role_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Library header-icon" role="button" id="dropdownMenuButtonPassportHandler" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonPassportHandler" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('passport_collect')
                                                                    <a href="{{route('passport_collect.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Receive Passports</a>
                                                                @endcan

                                                                @can('incoming_passport_transfer')
                                                                <a href="{{route('passport_collect')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Incoming Passport Transfer</a>
                                                                @endcan

                                                                @can('collected_passport_report')
                                                                <a href="{{route('passport_collect.report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Collected Passports Report</a>
                                                                @endcan

                                                                @can('request_passport')
                                                                <a href="{{route('request_passport.request')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Passport Request</a>
                                                                @endcan

                                                                @can('requested_passport')
                                                                <a href="{{route('request_passport.list')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Requested Passports</a>
                                                                @endcan

                                                                @can('outgoing_passport_transfer')
                                                                <a href="{{route('request_passport.outgoing_transfer')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Outgoing Passport Transfer</a>
                                                                @endcan

                                                                @can('remove_from_locker')
                                                                <a href="{{route('request_passport.locker_transfer')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Remove from locker</a>
                                                                @endcan

                                                                @can('not_returned_passport')
                                                                <a href="{{route('request_passport.notify_return')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Not Returned Passport</a>
                                                                @endcan

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Passport Handler</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole



                                        <?php  $career_by_office_array = ['Career_by_office_roll','Admin']; ?>
                                        @hasanyrole($career_by_office_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('career_by_office')
                                                                    <a href="{{route('career_by_office')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Career Candidate</a>
                                                                    <a href="{{route('career_by_office.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Candidate</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Career</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                        <?php  $follow_up_roll_array = ['Follow_up_roll','Admin']; ?>
                                        @hasanyrole($follow_up_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('follow_up_user')
                                                                    <a href="{{route('follow_up')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Followup All user</a>
                                                                @endcan

                                                                    @can('follow_up_dashboard')
                                                                        <a href="{{route('follow_up_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Followup Dashboard</a>
                                                                    @endcan

                                                                @can('follow_up_create_user')
                                                                    <a href="{{route('career_by_office.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Candidate</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Follow Up</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $own_bike_sim_roll_array = ['Own_bike_sim_roll','Admin']; ?>
                                        @hasanyrole($own_bike_sim_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('own_bike_sim')
                                                                    <a href="{{route('own_sim_bike')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Own Bike/Sim details</a>
                                                                @endcan
                                                                    @can('add_own_bike_sim')
                                                                        <a href="{{route('own_sim_bike.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Own Bike/Sim</a>
                                                                    @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Own Bike/Sim Riders</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole




                                        <?php  $ppuid_cancel_array = ['Ppuid_cancel','Admin']; ?>
                                        @hasanyrole($ppuid_cancel_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Close header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('ppuid_cancel_create')
                                                                    <a href="{{route('ppuid_cancel')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Cancel PPUID</a>
                                                                @endcan
                                                                @can('ppuid_cancel_report')
                                                                    <a href="{{url('ppuid_cancel_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">PPUID Report</a>
                                                                @endcan
                                                                @can('ppuid_cancel_history')
                                                                    <a href="{{url('ppuid_cancel_history')}}"   onclick="window.location.assign(this.href)" class="border border-dark">PPUID History</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">PPUID Cancel</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $assingt_to_dc_roll_array = ['Assign_to_dc_roll','Admin']; ?>
                                        @hasanyrole($assingt_to_dc_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Business-Mens header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('dc_dashboard')
                                                                    <a href="{{route('dc_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">DC Dashboard</a>
                                                                @endcan
                                                                    @can('dc_master_dashboard')
                                                                        <a href="{{route('dc_master_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">DC Master Dashboard</a>
                                                                    @endcan
                                                                @can('assign-to-dc-list')
                                                                    <a href="{{route('assign_to_dc')}}"   onclick="window.location.assign(this.href)" class="border border-dark">DC list</a>
                                                                @endcan
                                                                @can('add-to-assign-dc')
                                                                    <a href="{{route('assign_to_dc.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign Riders</a>
                                                                @endcan

                                                                    @can('add-to-assign-dc')
                                                                        <a href="{{route('bulk_assign_to_dc.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign Bulk Riders</a>
                                                                    @endcan


                                                               @can('assign-to-dc-transfer')
                                                                    <a href="{{route('dc_transfer_rider')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Transfer to DC</a>
                                                                @endcan

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Assign To DC</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $assingt_to_dc_roll_array = ['DC_roll']; ?>
                                        @hasanyrole($assingt_to_dc_roll_array)

                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Business-Mens header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('dc_dashboard')
                                                                    <a href="{{route('dc_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">DC Dashboard</a>
                                                                @endcan
                                                                @can('dc_riders')
                                                                    <a href="{{route('dc_riders')}}"   onclick="window.location.assign(this.href)" class="border border-dark">DC Riders</a>
                                                                @endcan
                                                                @can('dc_dashboard')
                                                                    <a href="{{route('rider_not_implement_attendance')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Not Implement Attendance</a>
                                                                @endcan

                                                                @can('dc_dashboard')
                                                                    <a href="{{route('rider_not_implement_orders')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Not Implement Orders</a>
                                                                @endcan



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Delivery Coordinator</p>

                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                        <?php  $assingt_to_dc_roll_array = ['DC_roll']; ?>
                                        @hasanyrole($assingt_to_dc_roll_array)

                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Unlock-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('dc_dashboard')
                                                                    <a href="{{route('onboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Make Checkin Request</a>
                                                                @endcan
                                                                @can('dc_riders')
                                                                    <a href="{{route('dc_request.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Make Checkout Request</a>
                                                                @endcan


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Make Assign Request</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                        <?php  $assingt_to_dc_roll_array = ['manager_user','Admin']; ?>
                                        @hasanyrole($assingt_to_dc_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Business-Mens header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('Admin')
                                                                    <a href="{{route('manager_user.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign To  Manager</a>
                                                                @endcan

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Assign User To Manager</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole



                                        <?php  $manager_roll_array = ['manager_dc','Admin']; ?>
                                        @hasanyrole($manager_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Business-Mens header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('manager_dc')
                                                                    <a href="{{route('dc_manager_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Manager of DC</a>
                                                                @endcan

                                                                @can('dc_riders')
                                                                    <a href="{{route('manager_user')}}"   onclick="window.location.assign(this.href)" class="border border-dark">All DC</a>
                                                                @endcan

                                                                    @can('manager_dc')
                                                                        <a href="{{route('request_for_teamleader')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Requests For Checkout</a>
                                                                    @endcan

                                                                    @can('manager_dc')
                                                                        <a href="{{route('checkin_request_for_teamleader')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Requests For Checkin</a>
                                                                    @endcan

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">DC Manager</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole



{{--                    4pl master--}}
                    <?php  $fourpl_array = ['FourplContractor','Admin']; ?>
                    @hasanyrole($fourpl_array)
                    <div class="col-md-2 menu-items-custom">
                        <div class="card card-icon mb-1">
                            <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="dropdown" >

                                    <i class="i-Shuffle-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                        <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                            @can('Four_pl_contracter_report')
                                                <a href="{{url('contractor_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">4PL Vendor Report</a>
                                            @endcan
                                            @can('Four_pl_contracter_report')
                                                <a href="{{url('contractor_salik')}}"   onclick="window.location.assign(this.href)" class="border border-dark">4PL Vendor Salik</a>
                                            @endcan
                                            @can('Four_pl_contracter_report')
                                                <a href="{{url('contractor_fine')}}"   onclick="window.location.assign(this.href)" class="border border-dark">4PL Vendor Fine</a>
                                                <a href="{{url('contractor_sim')}}"   onclick="window.location.assign(this.href)" class="border border-dark">4PL Vendor SIM Bill</a>
                                                <a href="{{url('contractor_bike_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">4PL Vendor Bike Details</a>
                                                <a href="{{url('contractor_sim_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">4PL Vendor SIM Details</a>
                                                <a href="{{url('vendor_portal')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Vendor Portal</a>
                                                <a href="{{url('vendor_onboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Vendor 4PL Riders On Board</a>
                                                <a href="{{url('vendor_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Vendor Dashboard</a>
                                                <a href="{{url('vendor_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Vendor Rider Report</a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted mt-2 mb-2">4 P Contractor</p>
                            </div>
                        </div>
                    </div>
                    @endhasanyrole


                                        <?php  $rta_array = ['RTAManage','Admin']; ?>
                                        @hasanyrole($rta_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Dashboard header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('rta_manage')
                                                                    <a href="{{url('vehicle-dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">RTA</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Manage RTA</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $rta_array = ['AgreedAmount','Admin']; ?>
                                        @hasanyrole($rta_array)
{{--                                        <div class="col-md-2 menu-items-custom">--}}
{{--                                            <div class="card card-icon mb-1">--}}
{{--                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                                    <div class="dropdown" >--}}

{{--                                                        <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>--}}
{{--                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">--}}
{{--                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">--}}
{{--                                                                @can('agreed_amount_list')--}}
{{--                                                                    <a href="{{url('agreed_amount')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Agreed Amounts</a>--}}
{{--                                                                @endcan--}}
{{--                                                                @can('add_agreed_amount')--}}
{{--                                                                    <a href="{{route('agreed_amount.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Create Agreed Amounts</a>--}}
{{--                                                                @endcan--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="text-muted mt-2 mb-2">Agreed Amount</p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        @endhasanyrole


                                        <?php  $fourpl_array = ['FourplContractor','Admin']; ?>
                                        @hasanyrole($fourpl_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Gear header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('Four_pl_contracter_report')
                                                                    {{-- <a href="{{url('bike')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike</a> --}}

                                                                    <a href="{{url('parts')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Parts</a>
                                                                    {{-- <a href="{{url('inv_parts')}}"   onclick="window.location.assign(this.href)" class="border border-dark">parts inventory</a> --}}
                                                                    <a href="{{url('manage_repair')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Manage Repair</a>
                                                                    <a href="{{url('price')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Price</a>
                                                                    <a href="{{url('price_history')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Price History</a>
                                                                    {{-- <a href="{{url('manage_repair_parts')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Manage Repair Parts</a> --}}

                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Maintenance</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $fourpl_array = ['FourplContractor','Admin']; ?>
                                        @hasanyrole($fourpl_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Clothing-Store header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('Four_pl_contracter_report')
                                                                    {{-- <a href="{{url('bike')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Bike</a> --}}

                                                                    <a href="{{url('inventory_controller')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Inventory Requests</a>


                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Inventory Controller</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole




                                        <?php  $project_manage_roles = ['Admin','ProjectManager']; ?>
                                        @hasanyrole($project_manage_roles)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Money-2 header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('ProjectManage')
                                                                    <a href="{{url('project')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Project</a>
                                                                    <a href="{{url('projectview')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Project View</a>
                                                                    <a href="{{url('project_invoice')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Invoice</a>
                                                                    <a href="{{url('invoiceview')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Invoice View</a>
                                                                    <a href="{{url('assignproject')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign Project</a>
                                                                    <a href="{{url('report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Report</a>

                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Cashier</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole




                                        <?php  $fourpl_array = ['career','Admin']; ?>
                                        @hasanyrole($fourpl_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Gear header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('career')
                                                                    <a href="{{ route('career_frontdesk')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Front Desk</a>
                                                                    <a href="{{ route('career_from_social_media')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Social Media Candidate</a>
                                                                    <a href="{{ route('career_from_on_call')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Ad Candidate on Call</a>
                                                                    <a href="{{ route('career_from_international')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add International Candidate</a>
                                                                    <a href="{{ route('career_from_walk')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Walkin Candidate</a>
                                                                    <a href="{{ route('wait_list')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Wait list</a>
                                                                    <a href="{{ route('need_to_take_licence')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Need To Take License</a>
                                                                    <a href="{{ route('career_selected_candidate') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Selected Candidate</a>
                                                                    <a href="{{ route('sent_interview') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Interview Sent</a>
                                                                    <a href="{{ route('career_report') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Career Report</a>
                                                                    <a href="{{ route('career_rejected') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Rejected Candidate</a>
                                                                    <a href="{{ route('missing_agreed_amount') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Missing Attachment Agreed Amount</a>
                                                                    <a href="{{ route('agreed_amount.index') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Agreed Amount</a>
                                                                    <a href="{{ route('agreed_amount.create') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Create Agreed Amount</a>

                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">New Career</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $fourpl_array = ['dc','Admin']; ?>
                                        @hasanyrole($fourpl_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Gear header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                @can('career')
                                                                    <a href="{{ route('dc_request.create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Make Request for Checkout</a>
                                                                    <a href="{{ route('request_for_teamleader')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Checkout Request For TeamLeader</a>
                                                                    <a href="{{ route('checkin_request_for_teamleader')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Checkin Request For TeamLeader</a>
                                                                    <a href="{{ route('checkout_type_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Checkout Reports</a>
                                                                    <a href="{{ route('send_to_checkout_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Send Direct To Checkout Report</a>
                                                                    <a href="{{ route('dc_sent_request_checkout')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Dc Sent Request For Checkout</a>
                                                                    <a href="{{ route('dc_sent_request_checkin')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Dc Sent Request For Checkin</a>
                                                                    <a href="{{ route('dc_to_accept_rider')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider Waiting For Dc</a>
                                                                    <a href="{{ route('team_leader_request_sent_for_dc')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Team Leader Sent Request To DC</a>


                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Dc Operation</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $talabat_dc_array = ['DC_roll','Admin']; ?>
                                        @hasanyrole($talabat_dc_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Gear header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">

                                                                {{-- @can('career') --}}
                                                                    <a href="{{ route('talabat_cod')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Talabat COD</a>
                                                                    <a href="{{ route('rider_wise_cod_statement')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Rider wise Statement (Talabat)</a>
                                                                    <a href="{{ route('talabat_user_wise_riders_cod_analysis') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Talabat COD City Wise Report</a>
                                                                    <a href="{{ route('manage_rider_codes') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Manage Rider Codes</a>
                                                                {{-- @endcan --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">COD Operation</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole



                                        <?php  $visa_process_array = ['VisaProcess','Admin','VisaProcessManager','VisaProcessEmiratesIdHandover']; ?>
                                        @hasanyrole($visa_process_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Visa header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                {{-- @can('VisaProcess','visa_process_visa_process') --}}
                                                                @can('visa_process_visa_process')
                                                                    <a href="{{ url('visa_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process</a>
                                                                    <a href="{{ url('visa_process_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process To Start</a>
                                                                    <a href="{{ url('own_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Own Visa</a>
                                                                    <a href="{{ url('own_visa_to_start')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Own Visa</a>
                                                                    <a href="{{ url('visa_process_pendings')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Visa Processes</a>
                                                                    @endcan
                                                                 @can('visa_process_manager')
                                                                 <a href="{{ url('visa_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process</a>
                                                                 <a href="{{ url('visa_process_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process To Start</a>
                                                                 <a href="{{ url('visa_process_pendings')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Visa Processes</a>
                                                                 <a href="{{ url('visa_process_payments')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process Payments</a>

                                                                 <a href="{{ url('visa_process_dashboard')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process Dashboard</a>

                                                                 <a href="{{ url('show_visa_expense')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process Expenses</a>

                                                                 <a href="{{ url('visa_process_companies')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Company Visa Process Report</a>

                                                                 <a href="{{ url('visa_category_details')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Category Visa Process</a>

                                                                 <a href="{{ url('own_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Own Visa</a>

                                                                 <a href="{{ url('own_visa_list')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Own Visa List</a>

                                                                 <a href="{{ url('own_visa_to_start')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Own Visa</a>

                                                                 <a href="{{ url('visa_pybass_list')}}"   onclick="window.location.assign(this.href)" class="border border-dark">By Passed Visa Process List</a>
                                                                 @endcan
                                                                 @can('eid_handover')
                                                                 <a href="{{ url('visa_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process</a>
                                                                 <a href="{{ url('visa_process_pendings')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Visa Processes</a>
                                                                 @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Visa Process</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $talabat_dc_array = ['rider_code_manager','Admin']; ?>
                                        @hasanyrole($talabat_dc_array)

                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Library header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                 {{-- @can('career') --}}
                                                                 <a href="{{ route('manage_rider_codes') }}"   onclick="window.location.assign(this.href)" class="border border-dark">Manage Rider Codes</a>
                                                                 {{-- @endcan --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Manage Rider Codes</p>
                                                </div>
                                            </div>
                                        </div>

                                        @endhasanyrole

                                        <?php  $visa_cancel_roll_array = ['Visa_cancel_pro','Visa_cancel_departments','Admin']; ?>
                                        @hasanyrole($visa_cancel_roll_array)

                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Close-Window header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('visa_cancel_visa_cancel')
                                                                    <a href="{{url('completed_visa_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Process Completed</a>
                                                                @endcan
                                                                @can('visa_cancel_visa_cancel')
                                                                <a href="{{url('all_cancel_requests_to_pro')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Visa Cancellation Requests</a>
                                                            @endcan
                                                                @can('visa_cancel_visa_cancel')
                                                                <a href="{{url('all_cancelled_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark">List of All Cancel</a>
                                                            @endcan
                                                                @can('visa_cancel_view_visa_clearance_report')
                                                                    <a href="{{url('cancel_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Cancel Visa</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p class="text-muted mt-2 mb-2">Visa Cancellation</p>



                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole



                                        <?php  $visa_renew_roll_array = ['Admin']; ?>
                                        @hasanyrole($visa_renew_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Newspaper header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                <a href="{{url('expired_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Expired Visas</a>
                                                                    @endcan
                                                                    @can('Admin')
                                                                    <a href="{{url('expired_visa')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Renew Expired Visas</a>
                                                                        @endcan

                                                                @can('Admin')
                                                                <a href="{{url('visa_renew')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Renew Visa </a>
                                                            @endcan
                                                            @can('Admin')
                                                            <a href="{{url('visa_renew/create')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Renew Visa Process Pendings</a>
                                                            @endcan

                                                            @can('Admin')
                                                            <a href="{{url('renew_visa_history')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Renewed History</a>
                                                            @endcan

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Renew Visa Process</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                        <?php  $visa_renew_roll_array = ['Admin']; ?>
                                        @hasanyrole($visa_renew_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Mail-Add- header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                <a href="{{url('takaful_emarat')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Insurance </a>
                                                            @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('gl_wmc')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Gl WMC</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Insurance</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole
                                        <?php  $visa_renew_roll_array = ['Admin','Jobs']; ?>
                                        @hasanyrole($visa_renew_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Geek header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin','jobs_jobs')                                                                <a href="{{url('jobs')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Create Job </a>
                                                            @endcan
                                                                @can('Admin','jobs_jobs')
                                                                    <a href="{{url('jobs_posted')}}"   onclick="window.location.assign(this.href)" class="border border-dark">List of Jobs</a>
                                                                @endcan

                                                                @can('Admin','jobs_jobs')
                                                                <a href="{{url('applicants_list')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Applicants</a>
                                                            @endcan

                                                            @can('jobs_jobs')
                                                                <a href="{{url('jobs')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Create Job </a>
                                                            @endcan
                                                                @can('jobs_jobs')
                                                                    <a href="{{url('jobs_posted')}}"   onclick="window.location.assign(this.href)" class="border border-dark">List of Jobs</a>
                                                                @endcan

                                                                @can('jobs_jobs')
                                                                <a href="{{url('applicants_list')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Applicants</a>
                                                            @endcan




                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Jobs</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                        <?php  $visa_renew_roll_array = ['Admin']; ?>
                                        @hasanyrole($visa_renew_roll_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Geek header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                <a href="{{url('accident_rider_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Make Accident Request</a>
                                                                <a href="{{url('accident_request_for_teamleader')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Accident Request For TeamLeader</a>
                                                                <a href="{{url('after_approved_requests')}}"   onclick="window.location.assign(this.href)" class="border border-dark">After Approved Requests</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Accident Request</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                        <?php  $box_installation = ['Admin']; ?>
                                        @hasanyrole($box_installation)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Motorcycle header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                <a href="{{url('box_install_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Box Install Request DC</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('dc_box_install_requests')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Box Requests From DC</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('box_request_rta')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Box Install Request RTA</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('box_requests')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Box Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('box_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Box Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('box_create_batch')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Create Batch</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('box_removal')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Box Removal</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('removed_boxes')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Removed Boxes</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Box Installation</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $food_permit = ['Admin']; ?>
                                        @hasanyrole($food_permit)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Motorcycle header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                    <a href="{{url('dc_request_food')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Food Permit Request DC</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('food_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Food Permit Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('food_permit_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Food Permit Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('food_permit_expiry')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Month Wise Expiry</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Food Permit</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $bike_renewal = ['Admin']; ?>
                                        @hasanyrole($bike_renewal)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Motorcycle header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                    <a href="{{url('bike_renewal')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Expired Bikes</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('pending_bike_renewal')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('pending_cash_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Cash Requests</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Bike Renewal</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $tracker_role = ['Admin']; ?>
                                        @hasanyrole($tracker_role)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Motorcycle header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                <a href="{{url('dc_request_for_tracker')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Tracker Request DC</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('rta_request_for_tracker')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Tracker Request RTA</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('tracker_requests')}}"   onclick="window.location.assign(this.href)" class="border border-dark">All Tracker Requests</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('tracker_upload')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Tracker Upload</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Tracker</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole

                                        <?php  $tracker_role = ['Admin']; ?>
                                        @hasanyrole($tracker_role)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >
                                                        <i class="i-Motorcycle header-icon" role="button" id="dropdownMenuButtonVisaCancellation" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonVisaCancellation" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                    <a href="{{url('accident_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Make Accident Request</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('accident_pending_request')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Waiting For Checkout</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('accident_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Accident Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('accident_pending_process')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Pending Accident Process</a>
                                                                @endcan
                                                                @can('Admin')
                                                                    <a href="{{url('loss_repair_bikes')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Process Completed Bikes</a>
                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Vehicle Accident</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole



                                        <?php  $visa_process_array = ['VisaProcess','Admin','VisaProcessManager','VisaProcessEmiratesIdHandover']; ?>
                                        @hasanyrole($visa_process_array)
                                        <div class="col-md-2 menu-items-custom">
                                            <div class="card card-icon mb-1">
                                                <div class="card-body text-center"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="dropdown" >

                                                        <i class="i-Safe-Box header-icon" role="button" id="dropdownMenuButtonSalarySheet" ></i>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSalarySheet" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(70px, 32px, 0px);">
                                                            <div class="menu-icon-grid dashboard-sub-menu text-center bd-highlight">
                                                                @can('Admin')
                                                                <a href="{{url('packages')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Add Packages</a>
                                                                <a href="{{url('package_assign')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Assign Package</a>
                                                                <a href="{{url('package_report')}}"   onclick="window.location.assign(this.href)" class="border border-dark">Package Report</a>

                                                                @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-2">Package</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endhasanyrole


                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- 4pl master--}}

                </div>

@endsection

@section('js')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script>
    $(".menu-search").keyup(function() {
    // Retrieve the input field text and reset the count to zero
    var filter = $(this).val(),
      count = 0;
    // Loop through the comment list
    $('.menu-items-custom').each(function() {
      // If the list item does not contain the text phrase fade it out
      if ($(this).text().search(new RegExp(filter, "i")) < 0) {
        $(this).hide(400);  // MY CHANGE

        // Show the list item if the phrase matches and increase the count by 1
      } else {
        $(this).show(400); // MY CHANGE
        count++;
      }

    });

    });
    </script>
@endsection
