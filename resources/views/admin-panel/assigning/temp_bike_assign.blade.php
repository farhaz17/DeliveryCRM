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
    </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Assignings</a></li>
            <li>Bike Check-in/Check-out</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <h4 class="card-title mb-3">Bike Assign</h4>

    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">








                <!-------------------------Bike content------------------------>

{{--                <div class="row">--}}

{{--                    <div class="col-md-4 form-group mb-6">--}}
{{--                        <label class="radio-outline-primary">--}}
{{--                            <input type="radio" id="pass-input2" name="radio" ><span>   &nbsp;Passport Number</span>--}}
{{--                        </label>--}}
{{--                        &nbsp;--}}

{{--                        <label class="radio-outline-success">--}}
{{--                            <input type="radio" id="pp-input2" name="radio"><span>   &nbsp;PPUID</span>--}}
{{--                        </label>--}}
{{--                        &nbsp;--}}

{{--                        <label class="radio-outline-warning">--}}
{{--                            <input type="radio" id="zds-input2" name="radio" ><span>   &nbsp;ZDS Code</span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <br><br><br>--}}
{{--                <form action ="{{ route('bike_assign') }}" method="POST" id="form_checkin">--}}
{{--                    {!! csrf_field() !!}--}}
{{--                    <div class="row">--}}



{{--                        <div class="col-md-3 form-group mb-3" id="passport_div" style="display: none">--}}
{{--                            <label for="repair_category">Passport Number</label><br>--}}
{{--                            <div id="all-check" >--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3 form-group mb-3" id="ppuid_div" style="display: none">--}}
{{--                            <label for="repair_category">PPUID</label><br>--}}
{{--                            <div id="all-ppuid" >--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-3 form-group mb-3" id="zds_code_div" style="display: none">--}}
{{--                            <label for="repair_category">ZDS Code</label><br>--}}
{{--                            <div id="all-zds" >--}}
{{--                            </div>--}}


{{--                        </div>--}}


{{--                        <div class="col-md-3 form-group mb-3" id="unique_div1" style="display: none" >--}}
{{--                            <label for="repair_category">Name</label><br>--}}
{{--                            <h6><span id="sur_name1" ></span>  <span id="given_names1" ></span></h6>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3 form-group mb-3">--}}
{{--                            <label for="repair_category">Bike</label>--}}
{{--                            <br>--}}
{{--                            <select id="bike" name="bike" class="form-control  form-control" required>--}}
{{--                                <option value=""  >Select option</option>--}}

{{--                                @foreach($checked_out as $bike)--}}
{{--                                    @if($bike["cencel"]=="")--}}
{{--                                        <option value="{{ $bike["id"] }}">{{ $bike["bike"]  }}</option>--}}
{{--                                    @else--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}


{{--                        <div class="col-md-3 form-group mb-3">--}}
{{--                            <label for="repair_category">Check IN</label>--}}
{{--                            <input class="form-control form-control" id="checkin" name="checkin" type="datetime-local" required  />--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <button class="btn btn-primary">Save</button>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </form>--}}
{{--                <br>--}}
                <!----------- Bike table ---------->
                <div class="col-md-12 mb-3">

                    <div class="card text-left">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="col-md-6 form-group mb-6 " id="names_div">


                                </div>

{{--                                <table class="display table table-striped table-bordered" id="example"  style="width: 100%">--}}
{{--                                    <thead class="thead-dark">--}}
{{--                                    <tr>--}}

{{--                                        <th scope="col">Passport id</th>--}}
{{--                                        <th scope="col">Bike Id</th>--}}
{{--                                        <th scope="col">Checkin</th>--}}
{{--                                        <th scope="col">Checkout</th>--}}
{{--                                        <th scope="col">Remarks</th>--}}
{{--                                        <th scope="col">Remarks</th>--}}
{{--                                        <th scope="col">PPUID</th>--}}
{{--                                        <th scope="col">ZDS Code</th>--}}
{{--                                        <th scope="col">Name</th>--}}
{{--                                        <th scope="col">Plate No</th>--}}
{{--                                        <th scope="col">Checkin</th>--}}
{{--                                        <th scope="col">Checkout</th>--}}
{{--                                        <th scope="col">Images</th>--}}
{{--                                        <th scope="col">Remakrs</th>--}}
{{--                                        <th scope="col">Action</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody id="bodyData">--}}

{{--                                    </tbody>--}}
{{--                                </table>--}}

                                <table id="dataTable1" class="table table-bordered table-striped-col" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Passport</th>
                                        <th>Bike</th>
                                        <th>Checked IN</th>
                                        <th>Checked OUT</th>
                                        <th>Remark</th>

                                    </tr>
                                    </thead>
                                    <tbody id="bodyData">
                                    </tbody>
                                </table>



                            </div>
                        </div>
                    </div>
                </div>

            </div>






            <!--------- Bike CheckOut Model---------->
            <div class="modal fade" id="bike_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="row">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verifyModalContent_title">Bike Checkout</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">


                                <form  action="{{ action('Assign\AssginBikeController@update',"1") }}" id="bike_modal_form" method="post">


                                    <input type="hidden" id="bike_primary_id" name="primary_id_bike">

                                    {!! csrf_field() !!}


                                    {{ method_field('PUT') }}




                                    <label for="repair_category">Check Out</label>
                                    <input class="form-control form-control" id="checkout" name="checkout" type="datetime-local" required  />

                                    <label for="repair_category">Remarks</label>
                                    <input class="form-control form-control" id="remarks" name="remarks" type="text"   />


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

                    $(document).ready(function () {
                        // $('#example').DataTable( {
                        //     "aaSorting": [[0, 'desc']],
                        //     "pageLength": 10,
                        //     "columnDefs": [
                        //         {"targets": [0],"visible": true},
                        //     ],
                        //
                        //     "scrollY": false,
                        //     "scrollX": true,
                        // });

                    });







                {{--    $(document).ready(function () {--}}
                {{--        $("#unique_div").css('display','block');--}}
                {{--        var token = $("input[name='_token']").val();--}}
                {{--        $.ajax({--}}

                {{--            url: "getBikeData",--}}
                {{--            method: 'POST',--}}
                {{--            dataType: 'json',--}}
                {{--            data: { _token:token},--}}

                {{--            order: [[ 1, 'desc' ]],--}}
                {{--            pageLength: 10,--}}
                {{--            success: function(response) {--}}
                {{--                var len = 0;--}}
                {{--                if(response['data'] != null){--}}
                {{--                    len = response['data'].length;--}}
                {{--                }--}}
                {{--                // $(".append_div_result").remove();--}}
                {{--                var options = "";--}}
                {{--                options += '<table  class="table" id="datatable2"> ' +--}}
                {{--                    '<thead class="thead-dark" style="display: none">' +--}}
                {{--                    '<tr>' +--}}
                {{--                    '<th scope="col">Passport No</th>' +--}}
                {{--                    '<th scope="col">PPUID</th>' +--}}
                {{--                    '<th scope="col">ZDS code</th>' +--}}
                {{--                    '<th scope="col">Name</th>' +--}}
                {{--                    '<th scope="col">Checkin</th>' +--}}
                {{--                    '<th scope="col">Checkout</th>' +--}}
                {{--                    '<th scope="col">remarks</th>' +--}}
                {{--                    '</tr>' +--}}
                {{--                    '</thead>';--}}
                {{--                if(len > 0){--}}
                {{--                    for(var i=0; i<len; i++){--}}
                {{--                        var passport_no = response['data'][i].passport_no;--}}
                {{--                        var ppuid = response['data'][i].ppuid;--}}
                {{--                        var zds_code = response['data'][i].zds_code;--}}
                {{--                        var full_name = response['data'][i].full_name;--}}
                {{--                        var checkin = response['data'][i].checkin;--}}
                {{--                        var checkout = response['data'][i].checkout;--}}
                {{--                        var remarks = response['data'][i].remarks;--}}



                {{--                        // options += '<option value="'+id+'" data="'+plateform_count+'">'+given_name+'</option>';--}}


                {{--                        options +=  '<div class="append_elements">' +--}}
                {{--                            '<tr>' +--}}
                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+passport_no+'</label>' +--}}
                {{--                            '</td>' +--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+ppuid+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+zds_code+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+full_name+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+checkin+'</label>' +--}}
                {{--                            '</td>'+--}}
                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+checkout+'</label>' +--}}
                {{--                            '</td>'+--}}
                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+remarks+'</label>' +--}}
                {{--                            '</td>'+--}}
                {{--                            '</tr>';--}}

                {{--                    }--}}
                {{--                    options += '</table >';--}}
                {{--                    $("#names_div").empty();--}}
                {{--                    $("#names_div").append(options);--}}
                {{--                    $("#all-check").show();--}}
                {{--                    $('#datatable2').DataTable(--}}
                {{--                        {--}}
                {{--                            language: { search: "",--}}
                {{--                                sLengthMenu: "Show _MENU_",--}}
                {{--                                searchPlaceholder: "Search..."--}}
                {{--                            },--}}

                {{--                        });--}}

                {{--                }else{--}}

                {{--                    $("#names_div").empty();--}}
                {{--                }--}}

                {{--            }--}}


                {{--        });--}}

                {{--    });--}}


                {{--</script>--}}
                {{--<script>--}}
                {{--    $(document).ready(function() {--}}

                {{--        $.ajax({--}}
                {{--            url: "getBikeData'",--}}
                {{--            method: 'POST',--}}
                {{--            dataType: 'json',--}}
                {{--            data: {--}}
                {{--                _token:token},--}}

                {{--            order: [[ 1, 'desc' ]],--}}
                {{--            pageLength: 10,--}}


                {{--            success: function(response) {--}}

                {{--                var len = 0;--}}
                {{--                if(response['data'] != null){--}}
                {{--                    len = response['data'].length;--}}
                {{--                }--}}
                {{--                // $(".append_div_result").remove();--}}
                {{--                var options = "";--}}

                {{--                options += '<table  class="table" id="datatable2"> ' +--}}
                {{--                    '<thead class="thead-dark" style="display: none">' +--}}
                {{--                    '<tr>' +--}}
                {{--                    '<th scope="col">Passport</th>' +--}}
                {{--                    '<th scope="col">Bike </th>' +--}}
                {{--                    '<th scope="col">Checkin </th>' +--}}
                {{--                    '<th scope="col">Checkout </th>' +--}}
                {{--                    '<th scope="col">Remarks </th>' +--}}
                {{--                    '</tr>' +--}}
                {{--                    '</thead>';--}}
                {{--                if(len > 0){--}}
                {{--                    for(var i=0; i<len; i++){--}}
                {{--                        var passport_no = response['data'][i].passport_no;--}}
                {{--                        var ppuid = response['data'][i].ppuid;--}}
                {{--                        var zds_code = response['data'][i].zds_code;--}}
                {{--                        var full_name = response['data'][i].full_name;--}}
                {{--                        var plate_no = response['data'][i].plate_no;--}}
                {{--                        var checkin = response['data'][i].checkin;--}}
                {{--                        var checkout = response['data'][i].checkout;--}}
                {{--                        var remarks = response['data'][i].remarks;--}}

                {{--                        // options += '<option value="'+id+'" data="'+plateform_count+'">'+given_name+'</option>';--}}


                {{--                        options +=  '<div class="append_elements">' +--}}
                {{--                            '<tr>' +--}}
                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+passport_no+'</label>' +--}}
                {{--                            '</td>' +--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+plate_no+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+checkin+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+checkout+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '<td>' +--}}
                {{--                            ' <label class="append_elements"  for="vehicle1">'+remarks+'</label>' +--}}
                {{--                            '</td>'+--}}

                {{--                            '</tr>';--}}

                {{--                    }--}}
                {{--                    options += '</table >';--}}
                {{--                    $("#names_div").empty();--}}
                {{--                    $("#names_div").append(options);--}}
                {{--                    $('#datatable2').DataTable(--}}
                {{--                        {--}}
                {{--                            language: { search: "",--}}
                {{--                                sLengthMenu: "Show _MENU_",--}}
                {{--                                searchPlaceholder: "Search..."--}}
                {{--                            },--}}

                {{--                        });--}}

                {{--                }--}}

                {{--            }--}}


                {{--        });--}}


                {{--    });--}}


                {{--    var table = $('.datatable_close').DataTable({});--}}



                {{--</script>--}}
{{--                <script>--}}
                    $(document).ready(function() {
                        $.ajax({
                            url: "getBikeData",
                            type: "POST",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            cache: false,
                            dataType: 'json',
                            success: function (dataResult) {
                                console.log(dataResult);
                                var resultData = dataResult.data;

                                var bodyData = '';
                                var i = 1;
                                $.each(resultData, function (index, row) {
                                    bodyData += "<tr>"
                                    bodyData +=  +
                                        "<td>" + row.passport_id + "</td>" +
                                        "<td>" + row.bike + "</td>" +
                                        "<td>" + row.checkin + "</td>" +
                                        "<td>" + row.checkout + "</td>" +
                                        "<td>" + row.remarks + "</td>";
                                    bodyData += "</tr>";
                                })
                                $("#bodyData").append(bodyData);
                                $('#dataTable1').DataTable( {
                                    "aaSorting": [[0, 'desc']],
                                    "pageLength": 10,
                                    "columnDefs": [
                                        {"targets": [0],"visible": true},
                                    ],

                                    "scrollY": false,
                                    "scrollX": true,
                                });


                            }
                        });
                    });



                </script>


{{--                <script>--}}
{{--                    $('#example').dataTable( {--}}
{{--                        "ajax": {--}}
{{--                            "url": "getBikeData",--}}
{{--                            "dataType": "json",--}}
{{--                            "type": "POST",--}}
{{--                            "data":  {--}}
{{--                                _token: '{{ csrf_token() }}'--}}
{{--                            },--}}
{{--                            success: function (dataResult) {--}}
{{--                                console.log(dataResult);--}}
{{--                                var resultData = dataResult.data;--}}
{{--                                var bodyData = '';--}}
{{--                                $.each(data, function (index, value) {--}}
{{--                                    dataTable.oApi._fnAddData(oSettings, [value.id,--}}
{{--                                        value.passport.passport_no,--}}
{{--                                        value.passport.pp_uid,--}}
{{--                                        value.passport.zds_code.zds_code,--}}
{{--                                        value.checkin,--}}
{{--                                        value.checkout,--}}
{{--                                        value.remarks,--}}

{{--                                    ]);--}}
{{--                                });--}}
{{--                                $("#bodyData").append(bodyData);--}}



{{--                            }--}}
{{--                        }--}}
{{--                    } );--}}

{{--                </script>--}}


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
                            }});


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


@endsection

