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
        </style>
@endsection
@section('content')

    <div class="row">
        <div class="card h-100 col-12">
            <div class="card-body">
                <div class="ul-widget__body mt-0">
                    <div class="row">
                        <?php  $company_manage_roll_array = ['CompanyManager','Admin']; ?>
                        @hasanyrole($company_manage_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('company_wise_dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">Company</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole
                        <?php  $rta_manage_roll_array = ['RTAManage','Admin']; ?>
                        @hasanyrole($rta_manage_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('vehicle_wise_dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">RTA</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole
                        <?php  $sim_manage_roll_array = ['SIMManage','Admin']; ?>
                        @hasanyrole($sim_manage_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('sim_wise_dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">SIM</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole
                        <?php  $customer_supplier_manage_roll_array = ['CustomerSupplierManage','Admin']; ?>
                        @hasanyrole($customer_supplier_manage_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('customer_supplier_wise_dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">Customer | Supplier</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php
                        // $wps_roll_array = ['Admin'];
                        ?>
                        {{-- @hasanyrole($wps_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('wps_dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">WPS</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole --}}
                        <?php  $hiringpoll_roll_array = ['Hiring-pool','Onboard','AgreedAmount',
                            'Admin','Hiring-front-desk',
                            'Hiring-add-career-social-media','Hiring-add-candidate-on-call',
                            'Hiring-add-international-candidate',
                            'Hiring-add-walkin-candidate',
                            'Hiring-wait-list',
                            'Hiring-selected-candidate',
                            'Hiring-referal-rewards',
                            'Hiring-create-new-interview-batch',
                            'Hiring-interview-btach-report',
                            'Hiring-onboard-report'];
                        ?>
                        @hasanyrole($hiringpoll_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('career_dashboard.index') }}" class="card-body text-center">
                                    <i class="i-File-Clipboard-Text--Image"></i>
                                    <p class="">Hiring</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $category_roll_array = ['Admin']; ?>
                        @hasanyrole($category_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('category-dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">Organized Category</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $passport_roll_array = ['Admin']; ?>
                        @hasanyrole($category_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('passport_dashboard') }}" class="card-body text-center">
                                    <i class="i-Password-shopping "></i>
                                    <p class="">Passport</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $dc_dashboard_roll_array = ['DC_roll','Admin']; ?>
                        @hasanyrole($dc_dashboard_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('dc_wise_dashboard') }}" class="card-body text-center">
                                    <i class="i-Business-Mens "></i>
                                    <p class="">DC Dashboard</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $dc_dashboard_roll_array = ['manager_dc','Admin']; ?>
                        @hasanyrole($dc_dashboard_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('dc_manager_dashboard_new') }}" class="card-body text-center">
                                    <i class="i-Business-Mens "></i>
                                    <p class="">DC Manager Dashboard</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $cod_roll_array = ['Admin','Cod','talabat_cod','deliveroo_cod','manager_dc']; ?>
                        @hasanyrole($cod_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('cod_dashboard_new') }}" class="card-body text-center">
                                    <i class="i-Dashboard "></i>
                                    <p class="">COD</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole


                        <?php  $visa_roll_array = ['Admin']; ?>
                        @hasanyrole($cod_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('visa_dashboard_new') }}" class="card-body text-center">
                                    <i class="i-Visa"></i>
                                    <p class="">Visa Process Dashboard</p>

                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $dc_dashboard_roll_array = ['Admin', 'Defaulter Rider Co-ordinator']; ?>
                        @hasanyrole($dc_dashboard_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('drc_dashboard') }}" class="card-body text-center">
                                    <i class="i-Business-Mens "></i>
                                    <p class="">Defaulter Rider Co-odinators</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole
                        <?php  $dc_dashboard_roll_array = ['Admin', 'Defaulter Rider Co-ordinator Manager']; ?>
                        @hasanyrole($dc_dashboard_roll_array)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('drcm_dashboard') }}" class="card-body text-center">
                                    <i class="i-Business-Mens "></i>
                                    <p class="">Defaulter Rider Co-odinator Manager</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $passport_role = ['Admin']; ?>
                        @hasanyrole($passport_role)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('passport-handler-dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">Passport Handler</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole

                        <?php  $accounts = ['Admin']; ?>
                        @hasanyrole($accounts)
                        <div class="col-2 mt-2">
                            <div class="card card-icon">
                                <a href="{{ route('accounts-dashboard') }}" class="card-body text-center">
                                    <i class="i-Dashboard"></i>
                                    <p class="">Accounts</p>
                                </a>
                            </div>
                        </div>
                        @endhasanyrole
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>

</script>
