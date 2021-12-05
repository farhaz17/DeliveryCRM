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
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Assign Bulk</a></li>
            <li>Assign Bulk rider To Dc</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a href="{{ asset('assets/sample/assign_rider_bulk/demo_file.xlsx') }}" download target="_blank">(Download Sample File)</a>
                    </div>

                    <div class="row display_dc_remain_div" >
                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold">Total DC LIMIT</label>
                            <h4 class="text-primary font-weight-bold" id="total_dc_html">0</h4>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold" >Total Rider Assigned TO DC</label>
                            <h4 class="text-info font-weight-bold" id="total_assigned_dc_html" >0</h4>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold">Total Limit Remain of DC</label>
                            <h4 class="text-success font-weight-bold" id="total_remain_dc_html" >0</h4>
                        </div>
                    </div>

                    <form method="post" enctype="multipart/form-data" action="{{ route('bulk_assign_to_dc.store') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}

                    <div class="row">
                        <div class="col-md-3 form-group"  style="float: left;" >
                            <label for="end_date">Browse File</label>
                            <input class="form-control" id="select_file" type="file" name="select_file" />
                        </div>

                        <div class="col-md-3 form-group mb-3 append_div">
                            <label for="repair_category">Select User</label>
                            <select class="form-control" name="dc_id" id="dc_id" required >
                                <option value="" selected  >select an option</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="repair_category">Select Platform</label>
                            <select class="form-control" id="platform_id" name="platform_id" >
                                <option value="">select an option</option>
                            </select>
                        </div>

                        <div class="col-md-3 form-group mb-3">
                            <label for="repair_category">Select Quantity</label>
                            <select class="form-control" id="quantity" name="quantity" >
                                <option value="">select an option</option>
                                @for($i=1; $i<=400; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor

                            </select>
                        </div>


                    </div>

                        <div class="col-md-12 form-group mb-3 "  style="float: left;"  >
                            <input  class="btn btn-primary" type="submit" value="Upload">
                        </div>

                        <div class="row display_remain_div" >
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category" class="font-weight-bold">Total Riders</label>
                                <h4 class="text-primary font-weight-bold" id="total_rider_html">0</h4>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category" class="font-weight-bold" >Total Assigned</label>
                                <h4 class="text-info font-weight-bold" id="total_assigned_rider_html" >0</h4>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category" class="font-weight-bold">Total Remain</label>
                                <h4 class="text-success font-weight-bold" id="total_remain_rider_html" >0</h4>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class=" text-left">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Upload Date</th>
                                    <th scope="col">Total value instead booking</th>
                                    <th scope="col">Total Count</th>
                                    <th scope="col">Uploaded File</th>
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
        $(document).ready(function () {
            $('#dc_id').select2({
                placeholder: 'Select an option'
           });

            $('#platform_id').select2({
                placeholder: 'Select an option'
            });

            $('#quantity').select2({
                placeholder: 'Select an option'
            });

        });
    </script>

    <script>
        $(document).on("change", "#dc_id", function (e) {
            e.stopPropagation();

            $("#select_platform").val("");
            $("#select_quantity").val("");
            $("#select_dc_id").val("");

            var user_id = $(this).val();
            var token = $("input[name='_token']").val();
            $("#platform_id").empty();
            $.ajax({
                url: "{{ route('get_passport_checkin_platform') }}",
                method: 'POST',
                dataType: 'json',
                data: {user_id: user_id, _token:token},
                success: function(response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = "";
                    if(len > 0){
                        var html_ab = '';

                        for(var i=0; i<len; i++){
                            // html_ab += '<option value="'+response[i].id+'">'+response[i].name+'</option>';
                            add_dynamic_opton(response[i].id,response[i].name);
                        }
                        // $("#platform_id").html(html_ab);
                    }
                }
            });

        });
        </script>

    <script>
        $(document).on("change", "#platform_id", function (e) {
            // e.stopPropagation();

            var selected_platform = $(this).val();
            var user_id = $( "#dc_id option:selected" ).val()


            if(selected_platform!=null){
                $.ajax({
                    url: "{{ route('get_remain_platform_counts') }}",
                    method: 'get',
                    data: {platform_id: selected_platform},
                    success: function(response) {

                        var  array = JSON.parse(response);

                        $(".display_remain_div").show(400);
                        $("#total_assigned_rider_html").html(array.total_rider_assigned);
                        $("#total_rider_html").html(array.total_rider_platform);
                        $("#total_remain_rider_html").html(array.total_rider_remain);

                    }
                });

                $.ajax({
                    url: "{{ route('get_remain_dc_counts') }}",
                    method: 'get',
                    data: {user_id: user_id,platform_id:selected_platform},
                    success: function(response) {

                        var  array = JSON.parse(response);

                        $(".display_dc_remain_div").show(400);
                        $("#total_dc_html").html(array.total_dc_limit);
                        $("#total_assigned_dc_html").html(array.total_rider_assigned);
                        $("#total_remain_dc_html").html(array.total_rider_remain);

                    }
                });



            }else{
                $(".display_remain_div").hide();
                console.log("we are in else");
            }




        });
        </script>

    <script>
        function add_dynamic_opton(id,text_ab){
            if ($('#platform_id').find("option[value='"+id+"']").length) {
                // $('#visa_designation').val('1').trigger('change');
            } else {
                // Create a DOM Option and pre-select by default

                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#platform_id').append(newOption);
            }
            $('#platform_id').val(null).trigger('change');
        }
    </script>


    <script>
        $(document).on("change", "#quantity", function (e) {
            // e.stopPropagation();
            var selected_value = $(this).val();
            var total_remain_dc = $("#total_remain_dc_html").html();

            var abc_value = parseInt(selected_value)

            if(abc_value > parseInt(total_remain_dc)){
                tostr_display("error","you are exceeded form the DC limit.!")
            }


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
