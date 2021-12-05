@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        .dataTable{
            width: 100% !important;
        }
        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>

        <ul>
            <li><a href="">Cash On Delivery Detail</a></li>
            <li>Cash On Delivery Detail</li>

        </ul>

    </div>
    <div class="separator-breadcrumb border-top"></div>

    <h4 class="text-center ">
        <span class="badge badge-success">{{ $rider->passport->personal_info->full_name }}</span>
    </h4>




    <div class="col-md-12 mb-3">
        <div class=" text-left">
            <div class="">

                <div class="card text-left">
                    <div class="card-body">

                                {{--accordian start--}}
                                <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                                    <div class="card">
                                        <div class="card-header header-elements-inline">
                                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                                        </div>
                                        <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                                            <div class="card-body">

                                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                                    <label for="start_date">Start Date</label>
                                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date">

                                                </div>

                                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">End Date</label>
                                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date">
                                                </div>

                                                {{-- <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                                    <label for="end_date">Select Platform</label>
                                                    <select class="form-control ab_cls" name="platform_id" id="platform_id" >
                                                        <option value="">select an option</option>
                                                        @foreach($plaforms as $plt)
                                                            <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}


                                                <input type="hidden" name="table_name" id="table_name" value="datatable" >

                                                <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                                    <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- accordian end here--}}

                                <div class="table-responsive">
                                    <table class="table table-sm table-striped table-bordered text-11" id="datatable_not_employee">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Rider id</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">Platform</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>
                                </div>




                    </div>
                </div>

            </div>
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
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
        </script>

    <script>
        $(document).ready(function () {
            // 'use-strict'
            //
            // $('#datatable_not_employee ,#datatable_part_time ,#datatable_taking_visa').DataTable( {
            //
            //     "pageLength": 10,
            //     "columnDefs": [
            //         {"targets": [0],"visible": false},
            //         { "width": 150, "targets": [3]},
            //     ],
            //
            //     scrollY: 300,
            //     responsive: true,
            //     // scrollX: true,
            //     // scroller: true
            // });
        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);

                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }) ;
        });
    </script>

    <script>
        function verify_load_data(from_date= '', end_date= ''){

            var table = $('#datatable_not_employee').DataTable(
                {
                    "pageLength": 10,
                    "columnDefs": [
                        {"targets": [0],"visible": false},
                        { "width": 150, "targets": [3]}
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
                    responsive: true,
                    "scrollY": false,
                    "scrollX": true,
                }
            );
        }
        </script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

            $('#category').select2({
                placeholder: 'Select an option'
            });

            $(".collapse_cls_pending").click(function(){

                $('#platform_id').select2({
                    placeholder: 'Select an option'
                });
                $(".select2-container").css('width','100%');
            });

        });

        $("#apply_filter").click(function(){
            var passport_id = $(this).val();
            var platform_id  =   4;
            var start_date  =   $("#start_date").val();
            var end_date  =   $("#end_date").val();
            var token = $("input[name='_token']").val();
            var rider_id =  "{{ Request::segment(2) }}";
            $.ajax({
                url: "{{ route('ajax_cod_history') }}",
                method: 'POST',
                data: {platform_id: platform_id,start_date:start_date,end_date:end_date, rider_id: rider_id, _token:token},
                success: function(response) {
                    console.log(response)
                    // $("#datatable").tbody.empty();
                    var ab_table = $('#datatable_not_employee').DataTable();
                    ab_table.destroy();

                    // console.log("wea are here");
                    $('#datatable_not_employee tbody').empty();
                    $('#datatable_not_employee tbody').append(response.html);

                    verify_load_data();
                    // $('#container').css( 'display', 'block !important' );
                    // $('.dataTables_scrollHeadInner').css( 'width', '100% !important' );
                    // $('#datatable_not_employee').css( 'display', 'table' );
                    // $('#container').css( 'width', 'block' );
                    // table.columns.adjust().draw();
                }
            });
        });

        $("#remove_apply_filter").click(function(){
            $('#platform_id').val(null).trigger('change');
            $("#start_date").val("");
            $("#end_date").val("");
            $("#apply_filter").click();
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
