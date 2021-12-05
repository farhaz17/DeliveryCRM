@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submenu{
            display: none;
        }
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    </style>
@endsection
@section('content')


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

    <div class="row">
        <div class="col-2">
            <div class="card card-icon bg-danger text-16  main-menu" id="master-menu" data-child-menu-items="master-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Business-Mens text-white "></i>
                    <h3 class="font-weight-bold mt-3 text-white">{{ $total_dc }}</h3>
                    <p class="p-0">Total DC</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-success text-16  main-menu" id="operations-menu" data-child-menu-items="operations-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Receipt-3 text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white">{{ $total_orders_today }}</h3>
                    <p class="p-0">Total Yesterday Orders</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-info text-16  main-menu" id="graphs-menu" data-child-menu-items="graphs-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Checked-User text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white">{{ $total_rider_assigned }}</h3>
                    <p class="p-0">Total Rider Assigned To DC</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-warning text-16  main-menu" id="renewal-menu"  data-child-menu-items="renewal-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Remove-User text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white">{{ $total_rider_without_dc }}</h3>
                    <p class="p-0">Total Rider Without DC</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-primary text-16  main-menu" id="reports-menu"  data-child-menu-items="reports-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Geek  text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white">{{ $today_absent }}</h3>
                    <p class="p-0">Today Absent Rider Of DC</p>
                </a>
            </div>
        </div>
        <div class="col-2">
            <div class="card card-icon  bg-secondary text-16  main-menu" id="documents-menu" data-child-menu-items="documents-menu-items">
                <a href="#" class="card-body text-center text-white m-0 p-0 pt-16">
                    <i class="i-Library header-icon text-white"></i>
                    <h3 class="font-weight-bold mt-3 text-white">{{ $total_dc }}</h3>
                    <p class="p-0">DC Report</p>
                </a>
            </div>
        </div>
    </div>
    <hr>
    <div class="submenu" id="master-menu-items" style="{{request('active') != null ? 'display:none ' : 'display:block'}}">

    </div>
    <div class="submenu"  id="operations-menu-items">


    </div>
    <div class="submenu"  id="graphs-menu-items">
        <div class="row">
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
            <div class="col-2 mb-2">
                <div class="card card-icon bg-info">
                    <a href="#" class="card-body text-center p-2 text-white">
                        <i class="nav-icon i-Dashboard"></i>
                        <span class="item-name">graphs</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="submenu" id="renewal-menu-items">

    </div>
    <div class="submenu" id="reports-menu-items">

    </div>

    <div class="submenu" id="documents-menu-items">

    </div>
@endsection

@section('js')
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
                url: "{{ route('get_dc_item_menu') }}",
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
