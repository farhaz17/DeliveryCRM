@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .setting_title {
            background: #efeaf5;
            padding: 1px;
            border-bottom: 1px solid #663399;
        }
       .setting-heading {
           padding-top: 12px;
           margin-left: 4px;
        }
        .description {
             /*padding: 13px;*/
            padding-top: 40px;
            font-size: 14px;
        }
        .setting-card {
             border: 1px solid #efeaf5;
         }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Performance</a></li>
            <li>Performance Setting</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 deliveroo_settings">
                            <div class="card-body m-2 setting-card">
                                <div class="setting_title">
                                    <h5 class="mb-2 setting-heading text-center" title="Critical fields , bad fields and good fields you want to compare with the performance sheet.">Deliveroo Settings</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 referal_settings">
                            <div class="card-body m-2 setting-card">
                                <div class="setting_title">
                                    <h5 class="mb-2 setting-heading text-center" title="Critical fields , bad fields and good fields you want to compare with the performance sheet.
                                    Referral credit amount , riders referral 'credit amount'.">Referral Credit Amount Settings</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 sim_shortage_setting">
                            <div class="card-body m-2 setting-card">
                                <div class="setting_title">
                                    <h5 class="mb-2 setting-heading text-center" title="Sim Shortage Setting will change the Steps to Assign Bike and Sim card.">Sim Shortage Settings</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 talabat_rider_performance">
                            <div class="card-body m-2 setting-card">
                                <div class="setting_title">
                                    <a href="{{ route('create_rider_performance_settings') }}"><h5 class="mb-2 setting-heading text-center" title="Rider Performance Setting will be used for getting the performance of a rider accourding to their platform.">Rider Performance Settings</h5></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    critical settings model--}}
    <div class="modal fade bd-example-modal-lg settings" id="bike_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="row">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Settings</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="all-detail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-------------crictical settings model ends here-----------------}}


{{-------------Refferal Credit Amount setting-----------------}}

    <div class="modal fade bd-example-modal-lg referal_settings_mdl" id="referal_settings_mdl" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="row">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Referral Credit Amount Settings</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="ref-detail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-------------------Refferal Credit Amount setting Ends here-----------------}}

{{---------------------Sim Shortage -----------------}}

    <div class="modal fade bd-example-modal-lg sim_shortage_mdl" id="sim_shortage_mdl_id" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="row">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Sim Shortage Settings</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body" style="background-color: #8080808c;">
                        <div id="sim_shortage_detail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-------------Sim Shortage Ends here-----------------}}

    {{--    critical settings model--}}
    <div class="modal fade bd-example-modal-lg" id="talabat_rider_performance_settings" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="row">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="talabat_rider_performance_settings_title">Talabat Rider Performance Settings</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div id="talabat_rider_performance_detail"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-------------crictical settings model ends here-----------------}}
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".deliveroo_settings").click(function(){
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('performance_setting_edit') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {_token: token},
                    success: function (response) {
                        $('#all-detail').empty();
                        $('#all-detail').append(response.html);
                        $('.settings').modal('show');
                    }});
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".referal_settings").click(function(){
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('referral_settings') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {_token: token},
                    success: function (response) {
                        $('#ref-detail').empty();
                        $('#ref-detail').append(response.html);
                        $('.referal_settings_mdl').modal('show');
                    }});
            });
        });
    </script>

{{--    sim shortage settings   --}}
    <script>
        $(document).ready(function () {
            $(".sim_shortage_setting").click(function () {
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('sim_shortage_setting') }}",
                    method: 'get',
                    dataType: 'json',
                    data: {_token: token},
                    success: function (response) {
                        $('#sim_shortage_detail').empty();
                        $('#sim_shortage_detail').append(response.html);
                        $('.sim_shortage_mdl').modal('show');
                    }
                });
            });
            $('#sim_shortage_detail').on('change', '.stats_sim_shortage', function() {
                var token = $("input[name='_token']").val();
                 var selected_val = "";
                 var ids = $(this).attr('id');
                if($(this).prop("checked") == true){
                    selected_val = 1;
                }else{
                    selected_val = 0;
                }
                $.ajax({
                    url: "{{ route('sim_shortage_setting.store') }}",
                    method: 'POST',
                    data: {_token: token,status:selected_val,id:ids},
                    success: function (response) {
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#talabat_rider_performance_settings").click(function(){
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "#",
                    method: 'POST',
                    dataType: 'json',
                    data: {_token: token},
                    success: function (response) {
                        $('#talabat_rider_performance_detail').empty();
                        $('#talabat_rider_performance_detail').append('Hello');
                        $('#talabat_rider_performance_settings').modal('show');
                    }});
            });
        });
    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>
@endsection
