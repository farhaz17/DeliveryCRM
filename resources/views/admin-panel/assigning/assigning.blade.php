@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        /*form {*/
        /*    margin: auto;*/
        /*    width: 70%;*/
        /*    padding: 10px;*/
        /*}*/

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Assignings</a></li>
            <li>Check-in/Check-out</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <h4 class="card-title mb-3">Assign</h4>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">SIM Check-In</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Bike Check-In</a></li>
        <li class="nav-item"><a class="nav-link" id="contact-basic-tab" data-toggle="tab" href="#contactBasic" role="tab" aria-controls="contactBasic" aria-selected="false">Plateform Check-In</a></li>
    </ul>
    <br><br><br>
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">





                    <div class="tab-content" id="myTabContent">



                        <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                            <form action ="{{ route('assign.store') }}" method="POST" >
                                {!! csrf_field() !!}
                                <div class="row">
                            <div class="col-md-3  mb-3">
                                <label for="repair_category">Passport Number</label>
                                <select id="passport_number" name="passport_id" class="form-control" required>
                                    <option value=""  >Select option</option>
                                    @foreach($passport as $pas)
                                    <option value="{{ $pas->id }}">{{ $pas->passport_no  }}</option>
                                    @endforeach
                                    </select>
                            </div>

{{--                            {{$sim_data}}--}}
{{--                                    @foreach($sim_data as $link)--}}
{{--                                        <p >{{ $link }}</p>--}}
{{--                                    @endforeach--}}
                            <div class="col-md-3 form-group mb-3 " id="unique_div" >
                                <label for="repair_category">Name</label>
{{--                                <input class="form-control form-control" id="name" name="nat_relation"  type="text" placeholder="Enter Relation" />--}}

                                <h4><span id="sur_name" ></span>  <span id="given_names" ></span></h4>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">SIM</label>
                                <select id="sim" name="sim" class="form-control" required>
                                    <option value=""  >Select option</option>
                                    @foreach($sim as $number)

                                        <option value="{{ $number->id }}">{{ $number->account_number  }}</option>


                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Check IN</label>
                                <input class="form-control form-control" id="checkin" name="checkin" type="datetime-local" required  />
                            </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-primary">Save</button>
                                    </div>

                                </div>
                            <br>
                                    <!-----------table ---------->
                                    <div class="col-md-12 mb-3">
                                        <div class="card text-left">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="display table table-striped table-bordered" id="datatable_sim" style="width: 100%">
                                                        <thead class="thead-dark">
                                                        <tr>

                                                            <th scope="col">Passport Number</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">SIM</th>
                                                            <th scope="col">Checkin</th>
                                                            <th scope="col">Checkout</th>

                                                            <th scope="col">Remakrs</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($assign_sim as $res_sim)
                                                            <tr>

                                                                <td>{{$res_sim->passport->passport_no}}</td>
                                                                <td>{{$res_sim->passport->personal_info->full_name}}</td>
                                                                <td>{{$res_sim->telecome->account_number}}</td>
                                                                <td>{{$res_sim->checkin}}</td>
                                                                <td>{{$res_sim->checkout}}</td>
                                                                <td>

                                                                    {{$res_sim->remarks}}
                                                                </td>
                                                                <td>
                                                                    <a class="text-success mr-2 sim_" id="{{ $res_sim->id  }}" href="javascipt:void(0)">
                                                                        <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                                                    </a>



                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


</form>

                        </div>

<!-------------------------Bike content------------------------>

                        <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                            <form action ="{{ route('bike_assign') }}" method="POST" >
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-3 form-group mb-3">
                                        <label for="repair_category">Passport Number</label>
                                        <select id="pass1" name="passport_id" class="form-control" required>
                                            <option value=""  >Select option</option>
                                            @foreach($passport as $pas)
                                                <option value="{{ $pas->id }}">{{ $pas->passport_no  }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                  <div class="col-md-3" id="unique_div1" >
                                   <label for="repair_category">Name</label>
                                   <h4><span id="sur_name1" ></span>  <span id="given_names1" ></span></h4>
                                 </div>
                             <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Bike</label>
                                 <br>
{{--                                                                  <select id="sim" name="sim" class="form-control" required>--}}
{{--                                                                      <option value=""  >Select option</option>--}}
{{--                                                                      @foreach($bikes as $bike)--}}
{{--                                                                          @foreach($bike_data as $link2)--}}
{{--                                                                              @if($bike->id == $link2))--}}
{{--                                                                              <option value="{{ $bike->id }}">{{$bike->plate_no }}</option>--}}
{{--                                                                              @else--}}
{{--                                                                              @endif--}}
{{--                                                                          @endforeach--}}
{{--                                                                      @endforeach--}}
{{--                                                                  </select>--}}



                                <select id="bike" name="bike" class="form-control  form-control" required>
                                    <option value=""  >Select option</option>

                                    @foreach($bikes as $bike)

                                        <option value="{{ $bike->id }}">{{ $bike->plate_no  }}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Check IN</label>
                                <input class="form-control form-control" id="checkin" name="checkin" type="datetime-local" required  />
                            </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary">Save</button>
                                    </div>

                        </div>
                                <br>
                                <!----------- Bike table ---------->
                                <div class="col-md-12 mb-3">
                                    <div class="card text-left">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display table table-striped table-bordered" id="datatable_bike" style="width: 100%">
                                                    <thead class="thead-dark">
                                                    <tr>

                                                        <th scope="col">Passport Number</th>
                                                        <th scope="col">PPUID</th>
                                                        <th scope="col">ZDS Code</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Plate No</th>
                                                        <th scope="col">Checkin</th>
                                                        <th scope="col">Checkout</th>
                                                        <th scope="col">Images</th>
                                                        <th scope="col">Remakrs</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($assign_bike as $res_bike)
                                                        <tr>

                                                            <td>{{$res_bike->passport->passport_no}}</td>
                                                            <td>{{$res_bike->passport->pp_uid}}</td>
                                                            <td>{{$res_bike->zds_code->zds_code}}</td>
                                                            <td>{{$res_bike->passport->personal_info->full_name}}</td>
                                                            <td>{{$res_bike->bike_plate_number->plate_no}}</td>
                                                            <td>{{$res_bike->checkin}}</td>
                                                            <td>{{$res_bike->checkout}}</td>
                                                            <td>
                                                                @if(isset($res_bike->bike_images))
                                                                    <a href="{{ url($res_bike->bike_images) }}" target="_blank">
                                                                        <img class="rounded-circle m-0 avatar-sm-table" src="{{ url($res_bike->bike_images) }}" alt="">
                                                                    </a>
                                                                @else
                                                                    <span class="badge badge-info">No Images</span>
                                                                @endif

                                                            </td>

                                                            <td>

                                                                {{$res_bike->remarks}}
                                                            </td>
                                                            <td>

                                                                <a  class="text-success mr-2 bik_"  @if($res_bike->status==0) style="display: none" @else  @endif  id="{{ $res_bike->id  }}" href="javascript:void(0)">
                                                                    <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>

                                                                    <a href="{{ route('bike_pdf',$res_bike->id) }}" target="_blank"><i class="fa fa-print"></i></a>
                                                                </a>

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>



<!---------------Plate form Content------------------>

                        <div class="tab-pane fade" id="contactBasic" role="tabpanel" aria-labelledby="contact-basic-tab">

                            <form action ="{{ route('plateform_assign') }}" method="POST" >
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-3  mb-3">
                                        <label for="repair_category">Passport Number</label>
                                        <select id="passport_number3" name="passport_id" class="form-control" required>
                                            <option value=""  >Select option</option>
                                            @foreach($passport as $pas)
                                                <option value="{{ $pas->id }}">{{ $pas->passport_no  }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-3 form-group mb-3 " id="unique_div3" >
                                        <label for="repair_category">Name</label>
                                        {{--                                <input class="form-control form-control" id="name" name="nat_relation"  type="text" placeholder="Enter Relation" />--}}

                                        <h4><span id="sur_name3" ></span>  <span id="given_names3" ></span></h4>
                                    </div>
                                    <div class="col-md-3 form-group mb-3">
                                        <label for="repair_category">Plateform</label>
                                        <select id="plateform" name="plateform" class="form-control" required>
                                            <option value=""  >Select option</option>

                                            @foreach($plateform as $plate)

                                                <option value="{{ $plate->id }}">{{ $plate->name  }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group mb-3">
                                        <label for="repair_category">Check IN</label>
                                        <input class="form-control form-control" id="checkin" name="checkin" type="datetime-local" required   />
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary">Save</button>
                                    </div>

                                </div>
                                <br>
                                <!----------- Bike table ---------->
                                <div class="col-md-12 mb-3">
                                    <div class="card text-left">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display table table-striped table-bordered" id="datatable_platform" style="width: 100%">
                                                    <thead class="thead-dark">
                                                    <tr>

                                                        <th scope="col">Passport Number</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Plateform</th>
{{--                                                        <th scope="col">Plateform Code</th>--}}
                                                        <th scope="col">Checkin</th>
                                                        <th scope="col">Checkout</th>

                                                        <th scope="col">Remarks</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($assign_plateform as $res_plateform)
                                                        <tr>

                                                            <td>{{$res_plateform->passport->passport_no}}</td>
                                                            <td>{{$res_plateform->passport->personal_info->full_name }}</td>
                                                            <td>{{$res_plateform->plateformdetail->name}}</td>
{{--                                                            <td>{{$res_plateform->passport->profile->user->verify_from->platform_code ? $res_plateform->passport->profile->user->verify_from->platform_code : "" }}</td>--}}
                                                            <td>{{$res_plateform->checkin}}</td>
                                                            <td>{{$res_plateform->checkout}}</td>


                                                            <td>

                                                                {{$res_plateform->remarks}}
                                                            </td>
                                                            <td>

                                                                <a class="text-success mr-2 plateform_"  id="{{ $res_plateform->id  }}" href="javascript:void(0)">
                                                                    <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                                                </a>


                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

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
{{--                        <div class="hidden_id" style="display: none">--}}
{{--                            @if(isset($checkout))--}}

{{--                                {{ $id=$checkout->id }}--}}

{{--                        </div>--}}

{{--                        @endif--}}

                        <form  action="{{action('Assign\AssignController@update', '1')}}" id="sim_form" method="post">


                            @method('PUT')


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


                        <!--------- Plateform CheckOut Model---------->
    <div class="modal fade" id="plateform_checkout" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Plateform Checkout</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">


                        <form  action="{{action('Assign\AssginPlateformController@update' ,"1")}}" id="plateform_modal_form" method="post">


                            <input type="hidden" id="plateform_primary_id" name="plateform_primary_id">

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






        $(document).ready(function () {
            'use-strict'

            $('#datatable_sim').DataTable( {
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



            $('#datatable_bike').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Currently Used Bikes',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
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

    <script>
        $("#passport_number").change(function () {
            $("#unique_div").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {

                    var res = response.split('$');
                    $("#sur_name").html(res[0]);
                    $("#given_names").html(res[1]);
                    $("#unique_div").show();
                    $("#exp_div").show();
                    // var name= $("#sur_name").html(res[0]);

                    // $("#name").val(function() {
                    //     return this.value + name;
                    // });
                }
            });

        });
    </script>

                            <script>
        $("#pass1").change(function () {
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
                    // var name= $("#sur_name").html(res[0]);

                    // $("#name").val(function() {
                    //     return this.value + name;
                    // });
                }
            });

        });
    </script>
                            <script>
        $("#passport_number3").change(function () {
            $("#unique_div3").css('display','block');
            var passport_id = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('sim_get_passport') }}",
                method: 'POST',
                data: {passport_id: passport_id, _token:token},
                success: function(response) {



                    var res = response.split('$');
                    $("#sur_name3").html(res[0]);
                    $("#given_names3").html(res[1]);
                    $("#unique_div3").show();
                    $("#exp_div").show();
                    // var name= $("#sur_name").html(res[0]);

                    // $("#name").val(function() {
                    //     return this.value + name;
                    // });
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
                 $(".sim_").click(function(){
                    var ids = $(this).attr('id');

                     var  action = $("#sim_form").attr("action");

                     var ab = action.split("assign/");

                     var action_now =  ab[0]+'assign/'+ids;

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

