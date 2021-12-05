@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item active" aria-current="page">Passport Dashboard</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Settings-Window text-white"></i>
                    <p class="p-0">Passport Master</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="oparation-menu" data-child-menu-items="oparation-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Checked-User text-white"></i>
                    <p class="p-0">Passport Operation</p>
                </a>
            </div>
        </div>

        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="agreed_amount"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Receipt-3  text-white"></i>
                    <p class="p-0">Passport Report</p>
                </a>
            </div>
        </div>



        {{--        <div class="col-2">--}}
        {{--            <div class="card card-icon  bg-info text-16  main-menu" id="new_visa"  data-child-menu-items="new-visa-items">--}}
        {{--                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">--}}
        {{--                    <i class="i-visa  text-white"></i>--}}
        {{--                    <p class="p-0">New Visa/Freelance</p>--}}
        {{--                </a>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        {{--        <div class="col-2">--}}
        {{--            <div class="card card-icon  bg-warning text-16  main-menu" id="not_new-visa"  data-child-menu-items="not_new-visa-items">--}}
        {{--                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">--}}
        {{--                    <i class="i-Credit-Card  text-white"></i>--}}
        {{--                    <p class="p-0">Not New Visa/Freelance</p>--}}
        {{--                </a>--}}
        {{--            </div>--}}
        {{--        </div>--}}



    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none' : 'display:block'}}">
        <div class="row">


{{--            <div class="col-2 mb-2">--}}
{{--                <div class="card card-icon  bg-danger">--}}
{{--                    <a href="{{ route('ppuid') }}" target="_blank" class="card-body text-center p-2 text-white">--}}
{{--                        <i class="nav-icon i-Checked-User header-icon"></i>--}}
{{--                        <span class="item-name">Passport PPUID</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-danger">
                    <a href="{{ route('passport') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Pen-3 header-icon"></i>
                        <span class="item-name">Create Passport</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('agreed_amount.create') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Pen-3 header-icon"></i>
                        <span class="item-name">Add Agreed Amount</span>
                    </a>
                </div>
            </div>


        </div>
    </div>
    <div class="submenu"  id="oparation-menu-items">
        <div class="row">


            <div class="col-2 mb-2">
                <div class="card card-icon  bg-success">
                    <a href="{{ route('passport_collect.create') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Pen-6 header-icon"></i>
                        <span class="item-name">Receive Passport</span>
                    </a>
                </div>
            </div>


        </div>
    </div>
    <div class="submenu" id="reports-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('passport') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">View Passport</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('visa_process_report_show') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Eye header-icon"></i>
                        <span class="item-name">Visa Process Report</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('star') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Visa header-icon"></i>
                        <span class="item-name">Visa Process</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ url('passport_history') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Clock-3 header-icon"></i>
                        <span class="item-name">Passport History</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('passport_collect') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Tractor header-icon"></i>
                        <span class="item-name">Incoming Passport Transfer</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('passport_collect.report') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Tractor header-icon"></i>
                        <span class="item-name">Collected Passport Report</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ url('request_passport') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Tractor header-icon"></i>
                        <span class="item-name">Rider Passport Request</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('request_passport.list') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Conference header-icon"></i>
                        <span class="item-name">Rider Requested Passport</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('request_passport.outgoing_transfer') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Conference header-icon"></i>
                        <span class="item-name">Outgoing Transfer</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('request_passport.locker_transfer') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Remove-User header-icon"></i>
                        <span class="item-name">Remove From Locker</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('request_passport.notify_return') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Remove-User header-icon"></i>
                        <span class="item-name">Not Returned Passport</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ url('agreed_amount') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Full-View-Window header-icon"></i>
                        <span class="item-name">View Agreed Amount</span>
                    </a>
                </div>
            </div>


            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ url('renew_agreed_amount') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Full-View-Window header-icon"></i>
                        <span class="item-name">View Renew Agreed Amount</span>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="submenu" id="new-visa-items">
        <div class="row">



        </div>
    </div>

    <div class="submenu" id="not_new-visa-items">
        <div class="row">


        </div>
    </div>



    <div class="submenu" id="agreed_amount-items">
        <div class="row">



            <div class="col-2 mb-2">
                <div class="card card-icon   bg-primary">
                    <a href="{{ route('career') }}" target="_blank"  target="_blank" class="card-body text-center p-2 text-white text-white">
                        <i class="nav-icon i-Conference"></i>
                        <span class="item-name">Pending</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('career_rejected') }}"  target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Remove-User"></i>
                        <span class="item-name">Rejected</span>
                    </a>
                </div>
            </div>



            <div class="col-2 mb-2">
                <div class="card card-icon   bg-primary">
                    <a href="{{ route('career_document_pending') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Document Pending/ShortList</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon   bg-primary">
                    <a href="{{ route('follow_up') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">Follow Up All User</span>
                    </a>
                </div>
            </div>





            <div class="col-2 mb-2">
                <div class="card card-icon  bg-primary">
                    <a href="{{ route('career_by_office') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Checked-User header-icon"></i>
                        <span class="item-name">All user Add by Office</span>
                    </a>
                </div>
            </div>

            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ url('agreed_amount') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Full-View-Window header-icon"></i>
                        <span class="item-name">View Agreed Amount</span>
                    </a>
                </div>
            </div>


            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('only_new_visa_noc') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Visa header-icon"></i>
                        <span class="item-name">New Visa/Freelance</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-primary">
                    <a href="{{ route('not_new_visa_noc') }}" target="_blank" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Visa header-icon"></i>
                        <span class="item-name">NOT New Visa/Freelance</span>
                    </a>
                </div>
            </div>



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
            }
        });
    </script>
@endsection
