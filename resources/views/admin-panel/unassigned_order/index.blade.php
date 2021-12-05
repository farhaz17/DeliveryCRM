@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')

    {{--    <div class="separator-breadcrumb border-top"></div>--}}

    <style>

        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
        .download_link{
            white-space: nowrap;
        }
    </style>


    {{--accordian start--}}

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Financial"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Order</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_amount">{{ $total_orders }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body text-center"><i class="i-Motorcycle"></i>
                                <div class="content">
                                    <p class="text-muted mt-2 mb-0">Total Riders</p>
                                    <p class="text-primary text-24 line-height-1 mb-2" id="total_rider">{{ $rider_total }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--                    <div class="col-lg-4 col-md-6 col-sm-6" >--}}
                    {{--                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
                    {{--                            <div class="card-body text-center"><i class="i-Download"></i>--}}
                    {{--                                <div class="content">--}}
                    {{--                                    <a href="#" id="download_btn" class="download_link">Last Day Order</a>--}}
                    {{--                                    <p class="text-primary text-24 line-height-1 mb-2"></p>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}



                </div>

                <div class="row">

                    <div class="col-md-3 form-group mb-3 "  style="float: left; "  >
                        <label for="batch_date">Select Platform</label>
                        <select class="form-control" name="normal_platfrom_id" id="normal_platform_id" >
                            <option value="" selected disabled>select an option</option>
                            @foreach($plaforms as $plt)
                                <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3 form-group mb-3 " style="float: left;" >
                        <label for="start_date">Start Date</label>
                        <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date">

                    </div>

                    <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                        <label for="end_date">End Date</label>
                        <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date">
                    </div>
                    <input type="hidden" name="table_name" id="table_name" value="datatable" >
                    <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                        <label for="end_date" style="visibility: hidden;">End Date</label>
                        <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                        <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </div>

    {{-- accordian end here--}}



    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-sm " id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('cods.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Select Status</label>
                                <select id="status" name="status" class="form-control form-control-rounded" required >
                                    <option value="" selected disabled>Select Option</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class=" text-left">
            <div class="">



                <div class="card text-left">
                    <div class="card-body">



                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">PlateForm</th>
                                    <th scope="col">Rider id</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total Order</th>
                                    <th scope="col">image</th>
                                    <th scope="col">Created At</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($unassigned_orders as $order)
                                    <tr>
                                        <td>{{ $order->passport->personal_info->full_name }}</td>
                                        <td>{{ $order->passport->rider_zds_code->zds_code }}</td>
                                        <td>{{ $order->platform->name }}</td>
                                        <?php

                                        $rider_code = $order->passport->platform_codes->where('platform_id','=',$order->platform_id)->first();
                                        $platform_code =  isset($rider_code->platform_code) ?  $rider_code->platform_code : '';
                                        ?>
                                        <td>{{ isset($platform_code)?$platform_code:"N/A" }}</td>
                                        <td>{{ $order->order_date }}</td>
                                        <td>{{ $order->no_of_orders }}</td>
                                        <td><a href="{{ asset($order->image) }}" target="_blank">see image</td>
                                        <td> {{ $order->created_at->todatestring() }}</td>

                                    </tr>

                                @endforeach

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
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
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


            $('#batch_date').select2({
                placeholder: 'select option of start and end date'
            });

            $('#normal_platform_id').select2({
                placeholder: 'select option '
            });


        });

        function get_main_digits(start_date , end_date='', platform=''){

            var ids = $(this).attr('id');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('unassigned_main_digit_ajax') }}",
                method: 'get',
                data: {start_date: start_date , end_date:end_date,platform:platform},
                success: function(response) {
                    var  array = JSON.parse(response);

                    $("#total_rider").html(array.total_rider);
                    $("#total_amount").html(array.total_amount);

                }
            });
        }

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
        $("#apply_filter").click(function(){

            var start_date  =   $("#start_date").val();
            var end_date  =   $("#end_date").val();
            var normal_platform_id  =   $("#normal_platform_id option:selected").val();



            if(start_date != '' &&  end_date != '' &&  normal_platform_id !='')
            {
                $('#datatable_not_employee').DataTable().destroy();
                verify_load_data(start_date, end_date,normal_platform_id);
                get_main_digits(start_date,end_date,normal_platform_id);
            }
            else
            {
                tostr_display("error","All field is required");
            }
        });


        $("#remove_apply_filter").click(function(){

            // var start_date  =   $("#start_date").val();
            // var end_date  =   $("#end_date").val();
            // var normal_platform_id  =   $("#normal_platform_id option:selected").val();


          $("#start_date").val("");
          $("#end_date").val("");
            $("#normal_platform_id").val(null).trigger('change');

                $('#datatable_not_employee').DataTable().destroy();
                verify_load_data('', '','');
                get_main_digits('','','');

        });

        </script>



    <script>
         function verify_load_data(start_date,end_date,normal_platform_id) {


             var token = $("input[name='_token']").val();
             $.ajax({
                 url: "{{ route('unassigned_order_filter_ajax') }}",
                 method: 'get',
                 data: {platform_id: normal_platform_id,start_date:start_date,end_date:end_date, _token:token},
                 success: function(response) {
                     // $("#datatable").tbody.empty();
                     var ab_table = $('#datatable').DataTable();
                     ab_table.destroy();

                     $('#datatable tbody').empty();
                     $('#datatable tbody').append(response.html);

                     var table = $('#datatable').DataTable(
                         {   "pageLength": 10,
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 ['10 Rows', '25 Rows', '50 Rows', 'Show all']
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
                         }
                     );
                     $('#container').css( 'display', 'block' );
                     table.columns.adjust().draw();
                 }
             });

        }
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
