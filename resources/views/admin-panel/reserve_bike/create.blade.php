@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        .cursor_cls{
            cursor: pointer;
        }
    </style>

    <style>
        .modal_table .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }
        .modal_table h6{
            font-weight:800;
        }
        .remarks{
            font-weight:800;
        }
        .modal_table .table td{
            padding: 2px;
            font-size: 12px;
        }

        #detail_modal  .separator-breadcrumb{
            margin-bottom: 0px;
        }
        .dataTables_info{
            display:none;
        }
    </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Reserve Bike</a></li>
            <li>Reserve Bike</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    view Detail modal--}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <input type="hidden" id="batch_id" name="batch_id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive modal_table">
                                <table class="table table-bordered table-striped" id="interview_users">
                                    <thead>
                                    <tr>
                                        <th ><b class="font-weight-800">Name</b></th>
                                        <th><b class="font-weight-800">Passport Number</b></th>
                                        <th><b class="font-weight-800">Nationality</b></th>
                                        <th><b class="font-weight-800">Bike</b></th>
                                        <th><b class="font-weight-800">Sim</b></th>
                                        <th><b class="font-weight-800">Action</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                            </div>



                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>
    {{--    view Detail modal end--}}


    {{--    view Detail modal reserved--}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal_reserved"  role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Detail</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="primary_id" name="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive modal_table">
                                <table class="table table-bordered table-striped" id="interview_users_reserved">
                                    <thead>
                                    <tr>
                                        <th ><b class="font-weight-800">Name</b></th>
                                        <th><b class="font-weight-800">Passport Number</b></th>
                                        <th><b class="font-weight-800">Nationality</b></th>
                                        <th><b class="font-weight-800">Bike</b></th>
                                        <th><b class="font-weight-800">Sim</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                            </div>



                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    {{--    view Detail modal end--}}




    <div class="row mb-4">
            <div class="col-md-6 float-left">
                <h4 class="card-title mb-3">Pending Reserve</h4>
                <div class="row">
                    @foreach($batches as $batch)

                    <div class="col-md-6 batch_div" id="{{ $batch->id }}">
                           <div class="card mb-4">
                             <div class="card-body cursor_cls">
                                        <h6 class="mb-3 text-dark">
                                            <i class="nav-icon i-Calendar-3"></i>
                                            <b>{{ $batch->created_at }}</b></h6>
                                        <h6 class="mb-3">
                                            <i class="nav-icon  i-Business-Mens"></i>
                                            <?php
                                             $total_user= isset($batch->pass_interviews) ? count($batch->pass_interviews) : 0
                                            ?>
                                            Pass Candidate: <b>{{ $total_user }}</b> </h6>
                                 <h6 class="mb-3">
                                     <i class="nav-icon  i-Business-Mens"></i>
                                     <?php
                                     $total_user= isset($batch->interviews) ? count($batch->interviews) : 0
                                     ?>
                                     Total Candidate: <b>{{ $total_user }}</b> </h6>

{{--                                        <h6 class="mb-3">--}}
{{--                                            <i class="nav-icon  i-Medal-2"></i>--}}
{{--                                            <b>{{ $batch->id }}</b>--}}
{{--                                        </h6>--}}
                                             <h6 class="mb-3">
                                                 <i class="nav-icon  i-Width-Window"></i>
                                                 <b></b>
                                             </h6>

                                    </div>
                            </div>
                    </div>

                    @endforeach
               </div>
            </div>

            <div class="col-md-6">
                <h4 class="card-title mb-3">Reserved</h4>
                <div class="row">
                    @foreach($batches_complete as $batch)

                        <div class="col-md-6 batch_div_reserved" id="{{ $batch->id }}">
                            <div class="card mb-4">
                                <div class="card-body cursor_cls">
                                    <h6 class="mb-3 text-dark">
                                        <i class="nav-icon i-Calendar-3"></i>
                                        <b>{{ $batch->created_at }}</b></h6>
                                    <h6 class="mb-3">
                                        <i class="nav-icon  i-Business-Mens"></i>
                                        <?php
                                        $total_user= isset($batch->pass_interviews) ? count($batch->pass_interviews) : 0
                                        ?>
                                        Pass Candidate: <b>{{ $total_user }}</b> </h6>
                                    <h6 class="mb-3">
                                        <i class="nav-icon  i-Business-Mens"></i>
                                        <?php
                                        $total_user= isset($batch->interviews) ? count($batch->interviews) : 0
                                        ?>
                                        Total Candidate: <b>{{ $total_user }}</b> </h6>

                                    <h6 class="mb-3">
                                        <i class="nav-icon  i-Width-Window"></i>
                                        <b></b>
                                    </h6>

                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
    </div>



            @endsection
            @section('js')
                <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
                <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
                {{--    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>--}}
                <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>





                <script>
                    $(document).on('click','.batch_div',function(){
                        var id = $(this).attr('id');

                        $("#batch_id").val(id);

                        var token = $("input[name='_token']").val();

                        $("#detail_modal").modal('show');
                        $.ajax({
                            url: "{{ route('ajax_interview_user') }}",
                            method: 'POST',
                            data: {batch_id: id, _token:token},
                            success: function(response) {

                                    $("#interview_users tbody").empty();
                                $('#interview_users tbody').append(response.html);

                                $('.bike_select_cls').select2({
                                    placeholder: 'Select an option'
                                });
                                $('.sim_select_cls').select2({
                                    placeholder: 'Select an option'
                                });
                            }
                        });
                    });

                    $(document).on('click','.batch_div_reserved',function(){
                        var id = $(this).attr('id');

                        $("#batch_id").val(id);

                        var token = $("input[name='_token']").val();

                        $("#detail_modal_reserved").modal('show');
                        $.ajax({
                            url: "{{ route('ajax_interview_user') }}",
                            method: 'POST',
                            data: {batch_id: id, type:'reserved', _token:token},
                            success: function(response) {

                                $("#interview_users_reserved tbody").empty();
                                $('#interview_users_reserved tbody').append(response.html);


                            }
                        });
                    });




                    $(document).on('click','.update_button_formate',function(){
                        var id = $(this).attr('id');

                        var token = $("input[name='_token']").val();
                        var bike_value =  $("#bike_select-"+id+" option:selected").val();
                        var sim_value =  $("#sim_select-"+id+" option:selected").val();

                        var batch_id = $("#batch_id").val();


                        if(bike_value != '' &&  sim_value != ''){

                            $.ajax({
                                url: "{{ route('reserve_bike.store') }}",
                                method: 'POST',
                                data: {passport_id: id, batch_id:batch_id,bike_value:bike_value,sim_value:sim_value, _token:token},
                                success: function(response) {

                                    if(response=="success"){
                                        tostr_display('success','Reservation has been done successfully');
                                    }else{
                                        tostr_display('error',response);
                                    }

                                }
                            });

                        }else{
                            tostr_display('error','Both Field Required');
                        }

                    });
                </script>

                <script>
                    $('#bike').select2({
                        placeholder: 'Select an option'
                    });
                    $('#passport_id').select2({
                        placeholder: 'Select an option'
                    });
                </script>

                <script>
                    $(document).on('change', '#passport_id', function(){
                        var abs = $(this).val();

                        $("#name_div").show();
                        var token = $("input[name='_token']").val();

                        $.ajax({
                            url: "{{ route('ajax_get_unique_passport') }}",
                            method: 'POST',
                            data: {type: "1", passport_id : abs ,  _token:token},
                            success: function(response) {
                                var ab = response.split("$");

                                $("#name_passport").html(ab[1]);
                            }
                        });
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
                    $("#pass-input2").change(function () {
                        // $("#unique_div1").css('display','block');
                        // var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();
                        $.ajax({
                            url: "{{ route('ajax_get_passports') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: token},
                            success: function (response) {
                                $('#all-check').empty();
                                $("#sur_name1").empty();
                                $("#given_names1").empty();
                                $("#unique_div1").hide();
                                $('#all-check').append(response.html);
                                $('#passport_div').hide();
                                $('#ppuid_div').hide();
                                $('#zds_code_div').hide();
                                $('#passport_div').show();
                                $(".select2-container").css("width","100%");

                                $('#pass1').select2({
                                    placeholder: 'Select an option'
                                });
                            }
                        });


                    });


                    $("#pp-input2").change(function () {
                        // $("#unique_div1").css('display','block');
                        // var passport_id = $(this).val();
                        var token = $("input[name='_token']").val();
                        $.ajax({
                            url: "{{ route('ajax_get_ppuid') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: token},
                            success: function (response) {
                                $('#all-ppuid').empty();
                                $("#sur_name1").empty();
                                $("#given_names1").empty();
                                $("#unique_div1").hide();
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
                            url: "{{ route('ajax_get_zds') }}",
                            method: 'POST',
                            dataType: 'json',
                            data: {_token: token},
                            success: function (response) {

                                $('#all-zds').empty();
                                $("#sur_name1").empty();
                                $("#given_names1").empty();
                                $("#unique_div1").hide();
                                $('#all-zds').append(response.html);
                                $('#passport_div').hide();
                                $('#ppuid_div').hide();
                                $('#zds_code_div').hide();
                                $('#zds_code_div').show();
                                $(".select2-container").css("width","100%");
                                $('#pass3').select2({
                                    placeholder: 'Select an option'
                                });
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
                    $(document).on('click','.bik_btn_cls',function(){
                        // $(".bik_btn_cls").click(function(){
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
                    function tostr_display(type,message){
                        switch(type){
                            case 'info':
                                toastr.info(message);
                                break;
                            case 'warning':
                                toastr.warning(message);
                                break;
                            case 'success':
                                toastr.success(message);
                                break;
                            case 'error':
                                toastr.error(message);
                                break;
                        }

                    }
                </script>



@endsection

