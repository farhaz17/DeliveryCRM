@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Assignings</a></li>
            <li>Office SIM Check-in/Check-out</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <h4 class="card-title mb-3">Office SIM Assign</h4>

    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <div class="col-md-12">
                    <form action ="{{ route('office_sim_checkin') }}" method="POST" >
                        @csrf
                        <div class="row">
                            <div class="col-md-2 form-group mb-3" id="passport_div" >
                                <label for="name">Name</label><br>
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Full Name">
                            </div>
                            <div class="col-md-2">
                                <label for="assigned_to">Assigned To</label>
                                <select id="assigned_to" name="assigned_to" class="form-control form-control-sm" required>
                                    <option value=""  >Select option</option>
                                    @foreach($assign_type as $as_type)
                                        <option value="{{$as_type->id}}">{{$as_type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sim_id">SIM</label>
                                <select id="sim" name="sim_id" class="form-control form-control-sm" required>
                                    <option value=""  >Select option</option>
                                    @foreach($checked_out as $number)
                                        <option value="{{ $number->id }}">{{ $number->account_number  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="checkin">Check IN</label>
                                <input class="form-control form-control-sm" id="checkin" name="checkin" type="datetime-local" required  />
                            </div>
                            <div class="col-md-2 form-group mb-3" id="ppuid_div">
                                <label for="remarks">Remarks</label>
                                <input type="text" name="remarks" class="form-control form-control-sm" placeholder="Remarks">
                            </div>
                            <div class="col-md-2">
                                <br>
                                <button class="btn btn-primary btn-sm btn-block" id="btn_checkin">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-----------table ---------->
                <div class="col-md-12 mb-3">
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered table-sm text-11" id="datatable_sim" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Assigned As</th>
                                <th>SIM</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>Remakrs</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($office_checked_in as $res_sim)
                                <tr>
                                    <td>{{$res_sim->name}}</td>
                                    <td>{{$res_sim->assign_to->name}}</td>
                                    <td>{{$res_sim->telecome->account_number}}</td>
                                    <td>{{$res_sim->checkin}}</td>
                                    <td>{{isset($res_sim->checkout)?$res_sim->checkout:''}}</td>
                                    <td>
                                        {{$res_sim->remarks}}
                                    </td>
                                    <td>
                                        <a  class="text-success mr-2 sim_btn_cls"  id="{{ $res_sim->id }}" @if($res_sim->status==0) style="display: none" @else   @endif href="javascipt:void(0)">
                                            <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                        </a>
                                        <a href="{{ route('office_sim_pdf',$res_sim->id) }}" target="_blank"><i class="fa fa-print"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!---------CheckOut Model---------->
            <div class="modal fade" id="form_update" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="row">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verifyModalContent_title">Checkout Sim</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <form  action="{{route('office_sim_checkout', '1')}}" id="sim_form" method="post">
                                    @method('GET')
                                    <input type="hidden" id="sim_primary_id" name="primary_id">
                                    {!! csrf_field() !!}
                                    <label for="repair_category">Check Out</label>
                                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" required  />
                                    <label for="repair_category">Remarks</label>
                                    <input class="form-control form-control" id="remarks" name="remarks" type="text"    />
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" > Save  </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--------checkout model ends--------->

            @endsection
            @section('js')
                <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
                <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
                <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
                <script>
                    $("#btn_checkin").click(function () {
                        $("#update_form").submit();
                    })


                </script>
                <script>
                    // $(document).ready(function () {
                    //     'use strict';
                    //
                    //     $('#datatable').DataTable( {
                    //         "aaSorting": [[0, 'desc']],
                    //         "pageLength": 10,
                    //         "columnDefs": [
                    //             {"targets": [0],"visible": true},
                    //             {"targets": [1][2],"width": "40%"}
                    //         ],
                    //         "scrollY": false,
                    //     });
                    //
                    // });

                    $('#passport_number').select2({
                        placeholder: 'Select an option'
                    });

                    $('#sim').select2({
                        placeholder: 'Select an option'
                    });

                    $('#assigned_to').select2({
                        placeholder: 'Select an option'
                    });

                    $(document).ready(function () {
                        'use-strict'

                        $('#datatable_sim').DataTable( {
                            "aaSorting": [[0, 'desc']],
                            "pageLength": 10,
                            "columnDefs": [
                                {"targets": [0],"visible": true},

                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'Office SIM Card Assign Report',
                                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page : 'all'

                                        }

                                    }
                                },
                                'pageLength',
                            ],
                            // scrollY: 300,
                            // responsive: true,
                            // scrollX: true,
                            // scroller: true
                            "scrollY": false,
                            "scrollX": true,
                        });
                        $('#datatable_bike').DataTable( {
                            "aaSorting": [[0, 'desc']],
                            "pageLength": 10,
                            "columnDefs": [
                                {"targets": [0],"visible": true},
                            ],

                            // scrollY: 300,
                            // responsive: true,
                            // scrollX: true,
                            // scroller: true
                            "scrollY": false,
                            "scrollX": true,
                        });


                        $('#datatable_platform').DataTable( {
                            "aaSorting": [[0, 'desc']],
                            "pageLength": 10,
                            "columnDefs": [
                                {"targets": [0],"visible": true},

                            ],

                            // scrollY: 300,
                            // responsive: true,
                            // scrollX: true,
                            // scroller: true
                            "scrollY": false,
                            "scrollX": true,
                        });
                    });

                    $(document).ready(function () {
                        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                            var currentTab = $(e.target).attr('id'); // get current tab

                            var split_ab = currentTab;
                            // alert(split_ab[1]);

                            if(split_ab=="home-basic-tab"){

                                var table = $('#datatable_sim').DataTable();
                                $('#container').css( 'display', 'block' );
                                table.columns.adjust().draw();
                            }else if(split_ab=="profile-basic-tab"){
                                $('#pass1').select2({
                                    placeholder: 'Select an option'
                                });

                                $('#bike').select2({
                                    placeholder: 'Select an option'
                                });



                                var table = $('#datatable_bike').DataTable();
                                $('#container').css( 'display', 'block' );
                                table.columns.adjust().draw();
                            }else{
                                $('#passport_number3').select2({
                                    placeholder: 'Select an option'
                                });
                                $('#plateform').select2({
                                    placeholder: 'Select an option'
                                });
                                var table = $('#datatable_platform').DataTable();
                                $('#container').css( 'display', 'block' );
                                table.columns.adjust().draw();
                            }


                        }) ;
                    });


                </script>
                {{--sims,passport,ppuid--}}
                <script>
                    $("#pass-input2").change(function () {
                        // $("#unique_div1").css('display','block');
                        // var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();
                        $.ajax({
                            url: "{{ route('ajax_get_sim_passports') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: token},
                            success: function (response) {
                                $('#all-check').empty();
                                $('#all-check').append(response.html);
                                $('#passport_div').hide();
                                $('#ppuid_div').hide();
                                $('#zds_code_div').hide();
                                $('#passport_div').show();
                                $(".select2-container").css("width","100%");

                                $('#pass1').select2({
                                    placeholder: 'Select an option'
                                });
                            }});


                    });


                    $("#pp-input2").change(function () {
                        // $("#unique_div1").css('display','block');
                        // var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();
                        $.ajax({
                            url: "{{ route('ajax_get_sim_ppuid') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: token},
                            success: function (response) {
                                $('#all-ppuid').empty();
                                $('#all-ppuid').append(response.html);
                                $('#passport_div').hide();
                                $('#ppuid_div').hide();
                                $('#zds_code_div').hide();
                                $('#ppuid_div').show();
                                $(".select2-container").css("width","100%");

                                $('#pass2').select2({
                                    placeholder: 'Select an option'
                                });
                            }});

                    });

                    $("#zds-input2").change(function () {
                        // $("#unique_div1").css('display','block');
                        // var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();
                        $.ajax({
                            url: "{{ route('ajax_get_sim_zds') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: token},
                            success: function (response) {

                                $('#all-zds').empty();
                                $('#all-zds').append(response.html);
                                $('#passport_div').hide();
                                $('#ppuid_div').hide();
                                $('#zds_code_div').hide();
                                $('#zds_code_div').show();
                                $(".select2-container").css("width","100%");
                                $('#pass3').select2({
                                    placeholder: 'Select an option'
                                });
                            }});
                    });

                </script>

                <script>
                    $(document).on('change','#pass2', function(){
                        $("#unique_div1").css('display','block');
                        var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();

                        $.ajax({
                            url: "{{ route('sim_get_passport') }}",
                            method: 'POST',
                            data: {passport_id: passport_id, _token:token},
                            success: function(response) {

                                var res = response.split('$');
                                $("#sur_name1").html(res[0]);
                                $("#given_names1").html(res[1]);
                                $("#unique_div1").show();
                                $("#exp_div").show();

                            }
                        });

                    });
                </script>

                <script>

                    $(document).on('change','#pass1', function(){
                        // $("#pass1").change(function () {
                        $("#unique_div1").css('display','block');
                        var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();


                        $.ajax({
                            url: "{{ route('sim_get_passport') }}",
                            method: 'POST',
                            data: {passport_id: passport_id, _token:token},
                            success: function(response) {

                                var res = response.split('$');
                                $("#sur_name1").html(res[0]);
                                $("#given_names1").html(res[1]);
                                $("#unique_div1").show();
                                $("#exp_div").show();
                                ;
                            }
                        });

                    });
                </script>

                <script>

                    $(document).on('change','#pass3', function(){
                        // $("#pass1").change(function () {
                        $("#unique_div1").css('display','block');
                        var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();


                        $.ajax({
                            url: "{{ route('sim_get_passport') }}",
                            method: 'POST',
                            data: {passport_id: passport_id, _token:token},
                            success: function(response) {

                                var res = response.split('$');
                                $("#sur_name1").html(res[0]);
                                $("#given_names1").html(res[1]);
                                $("#unique_div1").show();
                                $("#exp_div").show();

                            }
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



                <script>
                    $(".sim_btn_cls").click(function(){
                        var ids = $(this).attr('id');

                        var  action = $("#sim_form").attr("action");

                        var ab = action.split("office_sim_checkout/");

                        var action_now =  ab[0]+'office_sim_checkout/'+ids;

                        $("#sim_form").attr('action',action_now);

                        // $("#")
                        // alert(ab);

                        $("#sim_primary_id").val(ids);
                        $('#form_update').modal('show');
                    });
                </script>


                <script>
                    $(".bik_btn_cls").click(function(){
                        var ids = $(this).attr('id');

                        var  action = $("#bike_modal_form").attr("action");

                        var ab = action.split("assign_bike/");

                        var action_now =  ab[0]+'assign_bike/'+ids;

                        $("#bike_modal_form").attr('action',action_now);


                        $("#bike_primary_id").val(ids);
                        $('#bike_checkout').modal('show');
                    });
                </script>



                <script>
                    $(".plateform_btn_cls").click(function(){
                        var ids = $(this).attr('id');

                        var  action = $("#plateform_modal_form").attr("action");

                        var ab = action.split("assign_plateform/");

                        var action_now =  ab[0]+'assign_plateform/'+ids;

                        $("#plateform_modal_form").attr('action',action_now);


                        $("#plateform_primary_id").val(ids);
                        $('#plateform_checkout').modal('show');
                    });
                </script>


                @if(isset($checkout))

                    <script>
                        $(function(){
                            $('#form_update').modal('show')
                        });
                    </script>

                @endif

                @if(isset($bike_checkout))

                    <script>
                        $(function(){
                            $('#bike_checkout').modal('show')
                        });
                    </script>

                @endif

                @if(isset($plateform_checkout))

                    <script>
                        $(function(){
                            $('#plateform_checkout').modal('show')
                        });
                    </script>

    @endif



@endsection

