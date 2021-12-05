@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .label_caption{
            font-weight: 700;
            color : #000000 !important;
        }
        .color_block{
            cursor: pointer;
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
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">DC List</a></li>
            <li>DC</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="row">
        <div class="col-md-12">
            <div class="card mb-0">
                <div class="card-body">
                    @if($type=="absent_dc_rider")
                        <div class="card-title mb-3">TODAY ABSENT RIDER OF DC</div>
                   @elseif($type=="dc_rider")
                        <div class="card-title mb-3">DC LIST</div>
                    @else
                        <div class="card-title mb-3">Without DC LIST</div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group mb-3 float-left text-center color_block" id="absent_order">
            <li class="list-group-item border-0 ">
                <span style="background: #ed6a07" class="badge badge-square-primary xl m-1 font_size_cls" id="first_priority_hours_24_block">{{ $today_absent }}</span>
            </li>
            <label class="label_caption" for="start_date">Absent Rider</label>
        </div>
        <div class="col-md-4 form-group mb-3 float-left text-center color_block" id="not_implement_order">
            <li class="list-group-item border-0 ">
                <span  style="background: #ff2a47"  class="badge badge-square-secondary xl m-1 font_size_cls" id="first_priority_hours_48_block">{{ $total_order_not_implement }}</span>
            </li>
            <label  class="label_caption"  for="start_date">Rider Not implement Yesterday Order</label>
        </div>
        <div class="col-md-4 form-group mb-3 float-left text-center color_block" id="rider_on_leave">
            <li class="list-group-item border-0 ">
                <span style="background: #8b0000"  class="badge badge-square-success xl m-1 font_size_cls" id="first_priority_hours_72_block">{{ $today_leaves }}</span>
            </li>
            <label class="label_caption" for="start_date">Today Riders on Leave</label>
        </div>



    </div>


    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">



                    <div class="table-responsive">
                        <form action="{{ route('assign_to_dc.store') }}" method="POST">
                            @csrf
                            <input type="hidden" value="" id="select_platform" name="select_platform" >
                            <input type="hidden" value="" id="select_quantity" name="select_quantity" >
                            <input type="hidden" value="" id="select_dc_id" name="select_dc_id" >
                            <table class="display table table-sm table-striped table-bordered" id="datatable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Zds Code</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Platform Name</th>
                                    <th scope="col">DC Name</th>
                                    <th scope="col">Assign DC date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assign_to_dc as $user)
                                    <tr>
                                        <td>{{ $user->passport->personal_info->full_name }}</td>
                                        <td>{{ isset($user->passport->rider_zds_code->zds_code) ? $user->passport->rider_zds_code->zds_code : 'N/A' }}</td>
                                        <td>{{ $user->passport->passport_no }}</td>
                                        <td>{{ $user->platform->name }}</td>
                                        <td>{{ $user->user_detail->name }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td><a href="{{ route('profile.index') }}?passport_id={{ $user->passport->passport_no }}" target="_blank">see profile</a></td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="overlay"></div>
        </div>
    </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 25,
                "columnDefs": [
                    {"targets": [0][0],"width": "30%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'DC Riders',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
            });

        });
    </script>


    <script>
        $(".color_block").click(function () {

            var option = $(this).attr('id');
            make_filter_table(option);

        });
    </script>

    <script>
        function make_filter_table(option) {

            var token = $("input[name='_token']").val();
            var dc_id = "{{  Request::segment(3) }}"
            $.ajax({
                url: "{{ route('dc_rider_filter_ajax') }}",
                method: 'get',
                data: {type: option,dc_id:dc_id},
                success: function(response) {
                    // $("#datatable").tbody.empty();
                    var table = $('#datatable').DataTable();
                    table.destroy();

                    $('#datatable tbody').empty();
                    $('#datatable tbody').append(response.html);

                    var table = $('#datatable').DataTable(
                        {
                            "aaSorting": [],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            "columnDefs": [
                                {"targets": [0][0],"width": "30%"}
                            ],


                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'Pending Tickets',
                                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page : 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "scrollY": false,
                            "scrollX": true,
                        }
                    );
                    $(".display").css("width","100%");
                    $(".dataTables_scrollHeadInner").css("width","100%");
                    $('#datatable tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
            });

        }
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
