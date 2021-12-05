@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }



    </style>
@endsection
@section('content')
    <div class="breadcrumb">

        @if($type=="new")
            <h1 class="mr-2">New Upload SALIK DATA</h1>
        @else
            <h1 class="mr-2">Overwrite Upload SALIK DATA</h1>
                    @endif
        <ul>
            <li>Salik Sheet</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class=" text-left">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Company</th>
                                    <th scope="col">Transaction Id</th>
                                    <th scope="col">Trip date</th>
                                    <th scope="col">Toll Gate</th>
                                    @if(request()->segment(2)!="new")
                                    <th scope="col">Old Amount</th>
                                    @endif
                                    <th scope="col">Amount</th>
                                    <th scope="col">Plate</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($new_data  as $gamer)
                                    <tr>
                                        <td>{{  $gamer->get_account_detail->get_company_info->company_detail->name ? $gamer->get_account_detail->get_company_info->company_detail->name : 'N/A' }}</td>
                                        <td>{{  $gamer->transaction_id }}</td>
                                        <td>{{  $gamer->trip_date }}</td>
                                        <td>{{  $gamer->toll_gate }}</td>
                                        @if(request()->segment(2)!="new")
                                        <td>{{  $gamer->old_amount }}</td>
                                        @endif
                                        <td>{{  $gamer->amount }}</td>
                                        <td>{{  $gamer->plate }}</td>

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


    {{--    <div class="row pb-2" >--}}
    {{--        <div class="col-md-12">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}

    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="row pb-2" >
        <div class="col-md-12" id="render_calender">

        </div>
    </div>




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
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
            'use strict';

            $('#datatable_not_employee').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [1],"width": "15%"}
                ],
                "dom": 'Bfrtip',

                buttons: [

                    {
                        extend: 'excel',
                        title: 'Data',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "lengthMenu": [[10,25, 100,250, -1], [10,25, 100,250, "All"]],
                "scrollY": false,
            });

            $('#part_id').select2({
                placeholder: 'Select an option'
            });

            $('#account_number').select2({
                placeholder: 'Select an option'
            });


        });


        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
        //-----------Download sample divs------------------
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();


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
        $("#platform_id").change(function (){

            var ids = $(this).val();

            $("#render_calender").html("");

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('render_calender') }}",
                method: 'POST',
                data: {platform_id: ids ,_token:token},
                success: function(response) {
                    $("#render_calender").html(response);

                }
            });

        });
    </script>

    <script>
        $("#account_number").change(function () {

            var ids = $(this).val();

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_company_name') }}",
                method: 'POST',
                data: {id: ids ,_token:token},
                success: function(response) {
                    var  array = JSON.parse(response);

                    $("#div_complete").show();
                    $("#company_name_div").html(array.name);
                    $("#start_date_div").html(array.start_date);
                    $("#end_date_div").html(array.end_date);
                }
            });

        });
    </script>





@endsection
