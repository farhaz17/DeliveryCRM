<html lang="en" dir="">

<head>
    @include('admin-panel.base.head')
    @yield('css')
</head>

<body class="text-left">
{{-- <div class="app-admin-wrap layout-sidebar-large"> --}}
<div class="app-admin-wrap">
    @include('admin-panel.base.header')
    @if(Auth::check())

        @if(in_array(4, Auth::user()->user_group_id))

        @include('admin-panel.base.rider_sidemenu')

        @else

            {{-- @include('admin-panel.base.sidemenu') --}}
        @endif
   @endif

    <div class="main-content-wrap d-flex flex-column" style="margin-top: 10px; padding:10px">
        <!-- ============ Body content start ============= -->
        <div class="main-content">

{{--            small modal start--}}
{{--            <div class="modal fade " id="dc_modal_idicate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">--}}
{{--                <div class="modal-dialog modal-sm">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h5 class="modal-title text-danger font-weight-bold" id="exampleModalCenterTitle-1">Warning</h5>--}}
{{--                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            <h4  style="display: none;" id="attendance_text" class="text-danger">Your Rider Attendance is not completed, please complete the Attendance.!</h4>--}}
{{--                            <h4  style="display: none;" id="order_text" class="text-danger">Your Rider Order is not completed, please complete the Orders.!</h4>--}}

{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- end of main-content -->
{{--            <button style="display: none;" class="btn btn-primary" type="button" data-toggle="modal" data-target="#dc_modal_idicate" id="modal_sm_btn_dc">Small modal</button>--}}

            @yield('content')
        </div>
    </div>
</div>

@include('admin-panel.base.need_js')
<script>
    {{--$("#logout_btn_designation").click(function(){--}}


    {{--    $.ajax({--}}
    {{--        url: "{{ route('check_dc_riders_attendance_rider') }}",--}}
    {{--        method: 'get',--}}
    {{--        success: function (response) {--}}
    {{--            var  array = JSON.parse(response);--}}

    {{--            if(array.over_all_status=="1"){--}}
    {{--                $("#modal_sm_btn_dc").click();--}}
    {{--                if(array.rider_attendance_status=="1"){--}}
    {{--                    $("#attendance_text").show();--}}
    {{--                }--}}
    {{--                if(array.rider_order_status=="1"){--}}
    {{--                    $("#order_text").show();--}}
    {{--                }--}}

    {{--            }else{--}}

    {{--                window.location.href = '{{ route('logout') }}';--}}
    {{--            }--}}

    {{--        }--}}
    {{--    });--}}

    {{--});--}}
    </script>
@yield('js')
</body>

</html>
