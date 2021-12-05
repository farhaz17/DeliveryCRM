@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />

    <style>

    @font-face {
            font-family: Digital-7;
            src: url({{'assets/fonts/iconsmind/digital-7.ttf'}});
            font-weight: bold;
        }
        .text-attr-digit {
            font-size: 50px;
            font-weight: 900;
            color:#000000;
            font-family: Digital-7;
        }
        input#search2 {
            width: 20px;
            height: 20px;
        }
        input#search3 {
            width: 20px;
            height: 20px;
        }
        input#att_platform {
            width: 20px;
            height: 20px;
        }
        span.search-text {
            font-size: 15px;
            font-weight: 600;
        }

        .text-attr-platform{
            font-size: 12px;
            font-weight: 700;
        }
        .text-attr-platform2{
            font-size: 7px;
            font-weight: 800;
        }

        .block-update-card {
            /* height: 81%; */
            border: 1px #FFFFFF solid;
            width: 372px;
            float: left;
            margin-left: 25px;
            margin-top: 20px;
            padding: 0;
            box-shadow: 1px 1px 8px #d8d8d8;
            background-color: #FFFFFF;
            height: 60px;
        }
        .block-update-card .h-status {
            width: 100%;
            height: 7px;
            background: repeating-linear-gradient(45deg, #606dbc, #606dbc 10px, #465298 10px, #465298 20px);
        }
        .block-update-card .v-status {
            width: 5px;
            height: 80px;
            float: left;
            margin-right: 5px;
            background: repeating-linear-gradient(45deg, #606dbc, #606dbc 10px, #465298 10px, #465298 20px);
        }
        .block-update-card .update-card-MDimentions {
            width: 60px;
            height: 60px;
            position: relative;
            /* top: 10px; */
        }
        /*.block-update-card .update-card-body {*/
        /*    margin-top: 20px;*/
        /*    margin-left: 10px;*/
        /*    line-height: 6px;*/
        /*    cursor: pointer;*/
        /*}*/
        .block-update-card .update-card-body h4 {
            color: #737373;
            font-weight: bold;
            font-size: 13px;
        }
        .block-update-card .update-card-body p {
            color: #000000;
            font-size: 14px;
        }
        .block-update-card .card-action-pellet {
            padding: 5px;
        }
        .block-update-card .card-action-pellet div {
            margin-right: 10px;
            font-size: 15px;
            cursor: pointer;
            color: #dddddd;
        }
        .block-update-card .card-action-pellet div:hover {
            color: #999999;
        }
        .block-update-card .card-bottom-status {
            color: #a9a9aa;
            font-weight: bold;
            font-size: 14px;
            border-top: #e0e0e0 1px solid;
            padding-top: 5px;
            margin: 0px;
        }
        .block-update-card .card-bottom-status:hover {
            background-color: #dd4b39;
            color: #FFFFFF;
            cursor: pointer;
        }

        /*new*/
        img.title_imag-icon {
            height: 55px;
            width: 56px;
            max-width: 300px;
        }
        .card.card-profile-1.mb-4 {
            /*width: 380px;*/
            height: 80px;
            line-height: 5px;
            margin-left: 5px;
            margin-top: 3px;
            border-radius: 5px;
            border: 1px solid #bfbfbf;
        }
        p.text-attr-title.font-weight-bold {
            font-size: 16px;
            text-align: center;
            font-family: Roboto Slab;
        }
        p.text-attr {
            font-size: 16px;
            font-weight: 700;
            /*font-family: Redwing;*/
        }

    </style>
@endsection
@section('content')

    {{--            downlaod modal start--}}
    <div class="modal fade " id="button_download_btn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info font-weight-bold" id="exampleModalCenterTitle-1">Download Excel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row" id="download_btns">

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--            downlaod modal end--}}


    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="attendance-menu" data-child-menu-items="attendance-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Business-Mens text-white "></i>
                    <h3 class="font-weight-bold mt-3 text-white"></h3>
                    <p class="p-0">Attendance & Orders</p>


                </a>
            </div>
        </div>

        <div class="col-2">
            <div class="card card-icon  bg-info text-16  main-menu" id="four_pl_dcs" data-child-menu-items="graphs-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Checked-User text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white"></h3>
                    <p class="p-0">DCs</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-warning text-16  main-menu" id="company"  data-child-menu-items="renewal-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-University1 text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white"></h3>
                    <p class="p-0">Companies</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="bike"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Motorcycle  text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white"></h3>
                    <p class="p-0">Bikes</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-secondary text-16  main-menu" id="sim" data-child-menu-items="documents-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Memory-Card-2 header-icon text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white"></h3>
                    <p class="p-0">SIMs</p>
                </a>
            </div>
        </div>

        <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="other-menu" data-child-menu-items="operations-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Receipt-3 text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white"></h3>
                    <p class="p-0">Other</p>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none ' : 'display:block'}}">

    </div>

{{-- ------------------------------- --}}

<div class="col-sm-12 loading_msg" style="display: none">
    <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">

            <div class="loader-bubble loader-bubble-primary m-5"></div>
            <div class="loader-bubble loader-bubble-danger m-5" ></div>
            <div class="loader-bubble loader-bubble-success m-5" ></div>
            {{--                    <img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>--}}
        </div>
        <div class="col-sm-4">
        </div>
    </div>
</div>

{{-- ------------------------------- --}}




   {{-- -----------attendnace-------------------- --}}
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10 attendance_row">
</div>
<div class="col-md-1"></div>
</div>

   {{-- ------------------------------- --}}

      {{-- -----------dcs-------------------- --}}
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 dcs_row">
    </div>
    <div class="col-md-1"></div>
    </div>

       {{-- ------------------------------- --}}


            {{-- -----------comnpany-------------------- --}}
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 com_row">
    </div>
    <div class="col-md-1"></div>
    </div>

       {{-- ------------------------------- --}}

                   {{-- -----------bikes-------------------- --}}
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 bike_row">
    </div>
    <div class="col-md-1"></div>
    </div>

       {{-- ------------------------------- --}}

                          {{-- -----------sim-------------------- --}}
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10 sim_row">
    </div>
    <div class="col-md-1"></div>
    </div>

       {{-- ------------------------------- --}}

@endsection

@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>

    <script>

        $(document).on('click', '#attendance-menu', function(){
            var passport_id = $('#passport_bike').val();
            $.ajax({
                url: "{{ route('get_vendor_attenance') }}",
                dataType: 'json',
                beforeSend: function () {
                        $(".loading_msg").show();
                    },
                success: function (response) {
                    $(".attendance_row").empty();
                    $(".dcs_row").empty();
                    $(".com_row").empty();
                    $(".bike_row").empty();
                    $(".sim_row").empty();
                    $('.attendance_row').append(response.html);
                    $(".loading_msg").hide();
                }
            });
        });
    </script>



<script>

    $(document).on('click', '#four_pl_dcs', function(){

        $.ajax({
            url: "{{ route('get_vendor_dc') }}",
            dataType: 'json',
            beforeSend: function () {
                        $(".loading_msg").show();
                    },
            success: function (response) {
                $(".attendance_row").empty();
                $(".dcs_row").empty();
                $(".com_row").empty();
                $(".bike_row").empty();
                $(".sim_row").empty();
                $('.dcs_row').append(response.html);
                $(".loading_msg").hide();
            }
        });
    });
</script>



<script>
    $(document).on('click', '#company', function(){
        $.ajax({
            url: "{{ route('get_vendor_companies') }}",
            dataType: 'json',
            beforeSend: function () {
                        $(".loading_msg").show();
                    },
            success: function (response) {
                $(".attendance_row").empty();
                $(".dcs_row").empty();
                $(".com_row").empty();
                $(".bike_row").empty();
                $(".sim_row").empty();
                $('.com_row').append(response.html);
                $(".loading_msg").hide();
            }
        });
    });
</script>


<script>
    $(document).on('click', '#bike', function(){
        $.ajax({
            url: "{{ route('get_vendor_bike') }}",
            dataType: 'json',
            beforeSend: function () {
                        $(".loading_msg").show();
                    },
            success: function (response) {
                $(".attendance_row").empty();
                $(".dc_row").empty();
                $(".com_row").empty();
                $(".bike_row").empty();
                $(".sim_row").empty();
                $('.bike_row').append(response.html);
                $(".loading_msg").hide();
            }
        });
    });
</script>


<script>
    $(document).on('click', '#sim', function(){
        $.ajax({
            url: "{{ route('get_vendor_sim') }}",
            dataType: 'json',
            beforeSend: function () {
                        $(".loading_msg").show();
                    },
            success: function (response) {
                $(".attendance_row").empty();
                $(".dc_row").empty();
                $(".com_row").empty();
                $(".bike_row").empty();
                $(".sim_row").empty();
                $('.sim_row').append(response.html);
            }
        });
    });
</script>

    <script>
        @if(request('active') != null)
        $("#{{request('active')}}" ).show(600);
        @endif
        $('.main-menu').click(function(){
            $('.submenu').hide(600);
            var ids = $(this).attr('id');

            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_dc_item_menu_of_manager') }}",
                dataType: 'json',
                data: {id_menu: ids},
                success: function (response) {

                    var id_now = ids+"-items";
                    console.log(id_now);
                    $('#'+id_now).empty();
                    $('#'+id_now).append(response.html);

                }
            });

            $('#'+ $(this).attr('data-child-menu-items')).show(600);

        });
    </script>

    <script>
        $('#graphs-menu-items').on('click', '#download_btn_rider_assigned_dc', function() {

            $.ajax({
                url: "{{ route('get_manger_dc_user_button') }}",
                dataType: 'json',
                // data: {id_menu: ids},
                success: function (response) {
                    $("#download_btns").empty();
                    $('#download_btns').append(response.html);
                    $("#button_download_btn").modal('show');

                }
            });



        });
    </script>

    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>
@endsection
